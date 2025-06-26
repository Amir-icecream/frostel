<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-neutral-800 dark:text-white">
    <a href="/">home page</a>
    <span><?php echo(htmlspecialchars($id,ENT_QUOTES,"UTF-8")); ?></span>
    <span><?php echo(htmlspecialchars($name,ENT_QUOTES,"UTF-8")); ?></span>
    <img src="/storage/img/h.png" alt="">
</body>
</html>
