<?php
$type = get_class($e) ?? 'unknown';
$message = $e->getMessage() ?? 'internal server error';
$file = $e->getFile() ?? 'unknown';
$line = $e->getLine() ?? 'unknown';
$trace = $e->getTraceAsString() ?? 'no trace available';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>internal error</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .bt{
            border-color: rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-slate-100 dark:bg-zinc-900">
    <div class="fixed flex flex-col justify-start items-center mt-4 top-0 left-0 right-0 bottom-0 w-full h-full">
        <div class="w-11/12 h-fit rounded-t-md rounded-br-md shadow-lg flex flex-col justify-center items-center dark:bg-zinc-600 bg-slate-300 dark:text-white gap-3 text-lg hover:bg-opacity-50 duration-200 bt">
            <div class="flex justify-center items-center gap-3 w-full p-1">
                <p>internal server error</p>
                <span>|</span>
                <p>500</p>
            </div>
            <div class="flex justify-center items-start flex-col w-full border-t-1 p-2 gap-4 bt">
                <p><span>message :</span> <?php echo($message); ?></p>
                <p><span>line :</span> <?php echo($line); ?></p>
            </div>
            <div class="flex justify-start items-center border-t-1 p-2 w-full text-sm bt">
                <p><?php echo($trace); ?></p>
            </div>
        </div>
        <div class="w-11/12 flex">
            <div class="dark:bg-zinc-600 bg-slate-300 dark:text-white gap-3 text-lg rounded-b p-2 border-t-1 hover:bg-opacity-50 duration-200 bt">
                <p><span>Type :</span> <?php echo($type); ?></p>
            </div>
        </div>
    </div>
</body>
</html>