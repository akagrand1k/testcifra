Запуск проекта:
1)
composer install
npm install

2)
Настройка .env файла (прописать нужные credentials)
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

3)
Запуск миграций (используется mysql)
php artisan migrate 

4)
Генерация тестовых данных
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=ProductsTableSeeder

5)
Запуск backend тестов:
php artisan test

Данные тестового пользователя:
login: test@example.com
password: 123456
