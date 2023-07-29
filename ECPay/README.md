## After git clone Laravel

1. 還原 composer.json
    ```
    composer install
    ```
2. 還原 package.json (有用到的話)
    ```
    npm install
    ```

3. 複製 .env.example .env
    ```
    cp .env.example .env (linux)
    copy .env.example .env (windows)
    ```

4. 取得 APP_KEY
    ```
    php artisan key:generate
    ```
