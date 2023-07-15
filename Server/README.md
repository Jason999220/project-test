# 利用 api.php 成為前端與資料庫橋梁

## 建立 laravel 內建資料庫

### composer require laravel/breeze --dev

=> 安裝 Laravel Breeze 套件及其相依的套件

### php artisan breeze:install

=> 快速設定和安裝 Laravel Breeze 套件，建立使用者註冊、登入和驗證等功能

## STEP

### api.php 處理 前端 post or get 請求

利用網址，將前端的需求引導至相對應的函式

### 建立處理驗證的 Controller => AuthController.php

取得前端資料並交給資料庫，再將資料庫資料回傳給前端
