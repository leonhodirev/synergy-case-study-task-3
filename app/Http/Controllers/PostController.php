<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\PostAccessRequest;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->filled('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->input('tag_id'));
            });
        }

        $posts = $query->with('user', 'tags')
            ->orderByDesc('created_at')
            ->paginate(5);
        $tags = Tag::all();

        return view('post.index', compact('posts', 'tags'));
    }

    public function feed()
    {
        $user = auth()->user();
        $tags = Tag::all();
        $isFeed = true;

        // Получаем id пользователей, на которых подписан текущий пользователь
        $subscriptionIds = $user->subscriptions()->pluck('users.id')->toArray();

        // Получаем посты этих пользователей
        $posts = Post::whereIn('user_id', $subscriptionIds)
            ->where(function($query) use ($user) {
                $query->where('visibility', 'public')
                    ->orWhere(function($q) use ($user) {
                        $q->where('visibility', 'private')
                            ->whereJsonContains('allowed_user_ids', $user->id);
                    });
            })
            ->orderByDesc('created_at')
            ->paginate(5);


        return view('post.index', compact('posts', 'tags', 'isFeed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        $tags = Tag::all();

        return view('post.edit', compact('users', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $post = Post::create($data);
        $this->updateTags($request, $post);

        return redirect()->route('dashboard')->with('success', 'Пост создан');
    }

    private function updateTags(StorePostRequest $request, Post $post): void
    {
        $tags = $request->input('tags', []);
        $tagIds = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
            $tagIds[] = $tag->id;
        }
        $post->tags()->sync($tagIds);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $post = Post::findOrFail($id);
        $tags = Tag::all();
        $this->authorize('update', $post);

        $accessRequests = \App\Models\PostAccessRequest::where('post_id', $post->id)
            ->where('status', 'pending')
            ->with('user')
            ->get();

        $users = User::where('id', '!=', auth()->id())->get();

        return view('post.edit', compact('post', 'accessRequests', 'users', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $post->update($data);
        $this->updateTags($request, $post);

        return redirect()->route('dashboard')->with('success', 'Пост обновлён');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('update', $post);
        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Пост удалён');
    }

    public function requestAccess(Post $post)
    {
        $userId = auth()->id();

        // Проверка на наличие уже существующей заявки
        $exists = PostAccessRequest::where('post_id', $post->id)
            ->where('user_id', $userId)
            ->exists();

        if (!$exists) {
            PostAccessRequest::create([
                'post_id' => $post->id,
                'user_id' => $userId,
                'status' => 'pending',
            ]);
        }

        return back()->with('success', 'Запрос на доступ отправлен автору поста.');
    }
}
