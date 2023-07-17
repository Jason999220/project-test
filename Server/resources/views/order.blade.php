<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="POST" action="/orders">
        @csrf
        <h1>金額 : $200</h1>
        <div class="mb-4">
            <label >
                Name
            </label>
            <input
                name="name" id="name" type="text" placeholder="name">
        </div>
        <div class="mb-6">
            <label >
                Email
            </label>
            <input
                
                name="email" id="email" type="email" placeholder="email">
        </div>
        <div >
            <button
                type="submit">
                Submit Order
            </button>
        </div>
    </form>
</body>
</html>