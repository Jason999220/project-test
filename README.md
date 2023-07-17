# 前端、後端、資料庫串接

## 前端利用 【axios】 取得後端 API

## 後端利用 【 DB::select 】取得資料庫資料

## 資料庫寫 【procedure】 供後端使用

### 切記調整 .env 的 【DB_DATABASE】

## git clone 專案步驟後續處理
### git clone 後到client 終端機打 【npm start】 會出現以下錯誤訊息 
=> 【'react-scripts' 不是內部或外部命令、可執行的程式或批次檔。】
=> 接著輸入 【npm install react-scripts】即可開啟前端專案

### 處理後端
=> cd 後端專案 
=> composer install  
=>  php artisan key:generate
=> 將【.env.example】 改成【.env】調整資料庫
參考這篇文章
https://jntng.coderbridge.io/2020/07/14/clone-laravel-project-from-github/