<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo($message); ?></title>
    <link rel="stylesheet" href="/resource/css/style.css">
</head>
<body class="bg-slate-100 dark:bg-zinc-900">
    <div class="fixed flex justify-center items-center top-0 left-0 right-0 bottom-0 w-full h-full">
        <div class="w-96 h-52 rounded-md shadow-lg flex justify-center items-center dark:bg-zinc-600 bg-slate-300 bg-opacity-40 dark:text-white gap-3 text-2xl">
            <p><?php echo($error); ?></p>
            <span>|</span>
            <p><?php echo($message); ?></p>
        </div>
    </div>
</body>
</html>