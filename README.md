Запуск проекта;
0. composer install
npm install

1. Настройка .env файла (прописать нужные credentials)
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

2. Запуск миграций (используется mysql)
php artisan migrate 

3. Генерация тестовых данных
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=ProductsTableSeeder

4. Запуск backend тестов:
php artisan test

Данные тестового пользователя:
login: test@example.com
password: 123456
