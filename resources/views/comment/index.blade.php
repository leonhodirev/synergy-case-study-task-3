<?php

?>
<h3 class="mt-4 font-bold">Комментарии</h3>
@foreach($post->comments as $comment)
<div class="mb-2 p-2 border rounded">
    <strong>{{ $comment->user->name }}</strong>
    <span class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</span>
    <div>{{ $comment->content }}</div>
</div>
@endforeach

@auth
<form action="{{ route('comments.store', $post) }}" method="POST" class="mt-4">
    @csrf
    <div class="mb-2">
        <textarea name="content" class="form-control" rows="1" placeholder="Ваш комментарий">{{ old('content') }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary underline">Добавить комментарий</button>
</form>
@else
<p>Войдите, чтобы оставить комментарий.</p>
@endauth
