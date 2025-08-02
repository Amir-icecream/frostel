<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo(htmlspecialchars(csrf_token(),ENT_QUOTES,"UTF-8")); ?>">
    <title>frostel</title>
    <link rel="stylesheet" href="/resource/css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    <form action="form" method="post">
        <input name="X_CSRF_TOKEN" value="<?php echo(csrf_token()); ?>" id="csrf-token" hidden>
        <input type="text" name="username">
        <input type="password" name="pass" id="">
        <input type="submit" value="send">
    </form>
</body>
</html>