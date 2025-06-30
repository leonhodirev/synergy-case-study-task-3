<?php

?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>

                    <table class="table w-100">
                        <thead>
                        <tr>
                            <th>Заголовок</th>
                            <th>Статус</th>
                            <th>Дата создания</th>
                            <th>Запросы на доступ</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td>
                                    @if($post->visibility === 'private')
                                        <span class="badge bg-warning text-dark">Приватный</span>
                                    @else
                                        <span class="badge bg-success">Публичный</span>
                                    @endif
                                </td>
                                <td>{{ $post->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $post->accessRequests()->where('status', 'pending')->count() }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-primary underline">Редактировать</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="btn btn-sm btn-danger underline bg-red-600 text-white hover:bg-red-700"
                                            onclick="return confirm('Удалить пост?')">Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{ $posts->links() }}
                    </div>

                </section>
            </div>
        </div>
    </div>
</x-app-layout>
