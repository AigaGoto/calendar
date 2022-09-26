<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
        <!-- Styles -->
        <style>

        </style>
    </head>
    <body>
        <div class="container">
            <form action="schedule/add" method="post">
                <!-- CSRF保護 -->
                @csrf
                
                <p>イベント名</p>
                <input type="text" name="name">

                <p>日時</p>
                <input type="date" name="date">

                <input type="submit" value="登録">
            </form>
        </div>
    </body>
</html>
