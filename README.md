## Запуск приложения

**Технологии:** PHP 8.3.2, Laravel 12, PostgreSQL

**Команды:**
```bash
# Проверка установки PHP и Composer
php -v
composer -V

# Установка зависимостей
composer install

# Настройка подключения к базе данных в .env
# DB_CONNECTION=pgsql
# DB_HOST=localhost
# DB_PORT=5432
# DB_DATABASE=practike3
# DB_USERNAME=postgres
# DB_PASSWORD=postgres

# Миграция базы данных
php artisan migrate

# Можно наполнить тестовыми данными
php artisan db:seed

# Запуск локального сервера
php artisan serve

# Может потребоваться создать манифест
npm install && npm run build

```
Роуты
-------------------

      /             Главная страница -> Переход в авторизацию
      /login        Авторизация
      /register     Регистрация пользователя
      /posts/create Создание поста
      /users        Пользователи (Подписаться/Отписаться)
      /feed         Посты подписанных пользователей
      /posts        Публичные и приватно-доступные посты
      /dashboard    Посты пользователя, ссылки на редактирование и удаления
