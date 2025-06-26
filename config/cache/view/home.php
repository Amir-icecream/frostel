<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-neutral-800 dark:text-white" >
    <form action="/form" method="post" enctype="multipart/form-data">
        <input type="text" name="text">
        <input type="number" name="number">
        <input type="file" name="images[]" multiple>
        <input type="submit" value="submit">
    </form>
</body>
</html>

