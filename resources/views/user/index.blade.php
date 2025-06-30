<?php

?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <table class="table table-striped table-border">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if(in_array($user->id, $subscriptions))
                                        <form action="{{ route('users.unsubscribe', $user) }}" method="POST"
                                              style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm" style="color: red">Отписаться</button>
                                        </form>
                                    @else
                                        <form action="{{ route('users.subscribe', $user) }}" method="POST"
                                              style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm" style="color: green">Подписаться
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>

            </div>
        </div>
    </div>
</x-app-layout>
