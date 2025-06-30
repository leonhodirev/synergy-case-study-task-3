<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // Для каждого пользователя создаём по 2 поста
        foreach ($users as $user) {
            Post::create([
                'title' => 'Пост пользователя ' . $user->name,
                'content' => 'Пример содержимого.',
                'visibility' => 'public',
                'user_id' => $user->id,
            ]);
            Post::create([
                'title' => 'Приватный пост ' . $user->name,
                'content' => 'Только для избранных.',
                'visibility' => 'private',
                'allowed_user_ids' => [1, 2], // Пример: доступно первым двум пользователям
                'user_id' => $user->id,
            ]);
        }
    }
}
