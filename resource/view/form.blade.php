<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>frostel</title>
    <link rel="stylesheet" href="/resource/css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    <form action="form" method="post">
        @csrf
        <input type="text" name="username">
        <input type="password" name="pass" id="">
        <input type="submit" value="send">
    </form>
</body>
</html>