<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        $subscriptions = Auth::user()->subscriptions->pluck('id')->toArray();
        return view('user.index', compact('users', 'subscriptions'));
    }

    public function subscribe(User $user)
    {
        Auth::user()->subscriptions()->attach($user->id);
        return back()->with('success', 'Вы подписались на пользователя!');
    }

    public function unsubscribe(User $user)
    {
        Auth::user()->subscriptions()->detach($user->id);
        return back()->with('success', 'Вы отписались от пользователя!');
    }
}
