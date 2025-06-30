## Анализ работы

### 1. Создание web-страницы и окружения

**Команды:**
```bash
# Проверка установки PHP, Composer, Npm
php -v
composer -V
npm -v

# Установка Laravel (если не установлен глобально)
composer global require laravel/installer

# Создание нового проекта
laravel new case-study-task-3

# Переход в директорию проекта
cd case-study-task-3

# Настройка подключения к базе данных в .env
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=blog
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# Добавление русского языка
composer require laravel-lang/lang --dev
php artisan lang:update

# Изменение локали в .env
# APP_LOCALE=ru

# Запуск локального сервера
php artisan serve
```

---

### 2. Регистрация и вход пользователя

**Используемый пакет:** Laravel Breeze

**Команды:**
```bash
# Установка Breeze
composer require laravel/breeze --dev

# Установка Breeze в проект
php artisan breeze:install

# Миграция базы данных
php artisan migrate

# Создадим сидер для автоматического наполнения бд
php artisan make:seeder UserSeeder
php artisan db:seed
```

---

### 3. Создать функцию написания своего поста

```bash
# Создадим миграцию для таблицы постов с необходимыми полями и заполним модель
php artisan make:model Post -m

# Миграция базы данных
php artisan migrate

# Создадим сидер для автоматического наполнения бд
php artisan make:seeder PostSeeder
php artisan db:seed

# Создадим контроллер и заполним его
php artisan make:controller PostController --resource

# Создадим request чтобы избегать дублирующего кода
php artisan make:request StorePostRequest

# Зададим маршрут routes/web.php
# Создадим представление resources/views/post/edit.blade.php
```

---

### 4. Создать функцию подписки на пользователей

```bash
# Создадим миграцию для связи подписки
php artisan make:migration create_user_subscriptions_table

# Миграция базы данных
php artisan migrate

# Прописываем связи в модели User
# Создадим контроллер и заполним его
php artisan make:controller UserController

# Зададим маршрут routes/web.php
# Создадим представление resources/views/users/index.blade.php
```

---

### 5. Создать генерацию списка на основе подписок на пользователей

```bash
# Создадим метод feed в контроллере PostController
# Создадим представление index в posts
```
---

### 6. Создать функцию просмотра публичных постов

```bash
# Обновим метод (index()) в контроллере PostController
```

---

### 7. Создать функцию скрытого поста “только по запросу”

```bash
# Добавим новую сущность
php artisan make:migration create_post_access_requests_table
php artisan migrate
php artisan make:model PostAccessRequest -m

# Добавим в представление кнопку запроса на доступ resources/views/users/index.blade.php
# Зададим маршрут routes/web.php
# Добавим метод requestAccess в контроллере PostController

# Добавим в представление запросы пользователей на доступ resources/views/post/edit.blade.php
```

---

### 8. Создать функцию редактирования/удаления поста

```bash
# Создадим на /dashboard таблицу с уже созданными постами
# Создадим метод /dashboard в контроллере HomeController
# Изменим маршрут в routes/web.php
# Создадим ещё политику для поста
php artisan make:policy PostPolicy --model=Post
```

---

### 9. Предоставить возможность пользователю добавлять и сортировать посты по тегам

```bash
# Создадим модели тегов и промежуточной таблицы
php artisan make:model Tag -m
php artisan make:migration create_post_tag_table
php artisan migrate

# Добавим метод обновления тегов updateTags в контроллер PostController
# Добавим в метод постов фильтрацию по тегам в контроллер PostController
# *Добавлю в редактор Selectize.js
# Добавим изменения в представление всех постов
```

---

### 10. Добавить возможность комментировать посты

```bash
# Создадим модель и миграцию
php artisan make:model Comment -m
php artisan migrate
# Добавлю связи в Post, User, Comment

# Добавлю контроллер CommentController
php artisan make:controller CommentController

# Добавим маршрут в роуты
# Добавим представление в посты
```
