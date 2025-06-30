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
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Create post') }}
                            </h2>
                        </header>

                        <form method="post" action="{{ isset($post) ? route('posts.update', $post) : route('posts.store') }}" class="mt-6 space-y-6">
                            @csrf
                            @if(isset($post))
                                @method('PUT')
                            @endif

                            <div>
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                              autocomplete="current-title" required value="{{ old('title', $post->title ?? '') }}" />
                            </div>

                            <div>
                                <x-input-label for="content" :value="__('Content')" />
                                <textarea id="content" name="content" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                              autocomplete="current-content" required />{{ old('content', $post->content ?? '') }}</textarea>
                            </div>

                            <div>
                                <x-input-label for="content" :value="__('Visibility')" />

                                <select name="visibility" required>
                                    <option value="public" {{ old('visibility', $post->visibility ?? '') == 'public' ? 'selected' : '' }}>
                                        Публичный
                                    </option>
                                    <option value="private" {{ old('visibility', $post->visibility ?? '') == 'private' ? 'selected' : '' }}>
                                        Приватный
                                    </option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="allowed" :value="__('Allowed')" />
                                <select name="allowed_user_ids[]" id="allowed" multiple class="mt-1 block w-full">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                                @if(collect(old('allowed_user_ids', $post->allowed_user_ids ?? []))->contains($user->id)) selected @endif>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tags">Теги:</label>
                                <select id="tags" name="tags[]" multiple>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->name }}"
                                            {{ isset($post) && $post->tags->pluck('name')->contains($tag->name) ? 'selected' : '' }}>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tags')
                                <div class="text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'post-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>

                            <h4>Запросы на доступ</h4>
                            @if(isset($accessRequests) && $accessRequests->count())
                                <ul>
                                    @foreach($accessRequests as $request)
                                        <li>
                                            {{ $request->user->name }} ({{ $request->user->email }})
                                            <form action="{{ route('posts.approve_access', [$post, $request->user]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Добавить в доступ</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Нет новых запросов.</p>
                            @endif
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Selectize CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/selectize/dist/css/selectize.default.css">
<!-- Selectize JS -->
<script src="https://cdn.jsdelivr.net/npm/selectize/dist/js/standalone/selectize.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tags').selectize({
            create: true,
            persist: false,
            maxItems: null,
            placeholder: 'Введите или выберите теги'
        });
    });
</script>
