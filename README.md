    1) Установка зависимостей:
    composer install
    npm install
    
    3) Настройка .env файла (прописать нужные credentials)
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
    
    4) Запуск миграций (используется mysql)
    php artisan migrate 
    
    5) Генерация тестовых данных
    php artisan db:seed --class=UserSeeder
    php artisan db:seed --class=ProductsTableSeeder
    
    6) Запуск backend тестов:
    php artisan test
    
    Данные тестового пользователя:
    login: test@example.com
    password: 123456
