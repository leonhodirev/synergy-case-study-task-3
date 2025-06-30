<?php

?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>

                    <form method="GET" action="{{ route('posts.index') }}" style="margin-bottom: 20px">
                        <select name="tag_id">
                            <option value="">Все теги</option>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit">Фильтровать</button>
                    </form>

                    @if($posts->count())
                        @foreach($posts as $post)
                            <h5 class="font-bold">{{ $post->title }}</h5>

                            <div class="mb-1 text-muted">
                                Автор: {{ $post->user->name ?? 'Неизвестно' }},
                                {{ $post->created_at->format('d.m.Y H:i') }}
                                @if($post->visibility === 'private')
                                    <span class="badge bg-warning text-dark">Приватный</span>
                                @else
                                    <span class="badge bg-success">Публичный</span>
                                @endif
                            </div>

                            <div>
                                @foreach($post->tags as $tag)
                                    <span>{{ $tag->name }}</span>
                                @endforeach
                            </div>

                            <div>
                                @if(!isset($isFeed) && $post->visibility === 'private')
                                    <form action="{{ route('posts.request_access', $post) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary btn-sm underline">
                                            Запросить доступ
                                        </button>
                                    </form>
                                @else
                                    {{ Str::limit($post->content, 150) }}
                                @endif
                            </div>

                            @includeIf('comment.index', ['post' => $post])

                            @if(false)
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-link p-0 mt-2"
                                   style="text-decoration: underline">
                                    Читать полностью
                                </a>
                            @endif

                            <br>
                            <hr>
                            <br>
                        @endforeach

                        <!-- Пагинация -->
                        <div>
                            {{ $posts->links() }}
                        </div>
                    @else
                        <p>Нет постов для отображения.</p>
                    @endif

                </section>
            </div>
        </div>
    </div>
</x-app-layout>
