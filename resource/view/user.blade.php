<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User: <?= htmlspecialchars($username) ?></title>
    <link rel="stylesheet" href="/resource/css/style.css">  
</head>
<body class="bg-gradient-to-br from-blue-900 to-gray-900 text-white min-h-screen flex flex-col items-center justify-start p-6">
    <div class="max-w-full mx-auto w-4/12 bg-blue-800 rounded-lg shadow-lg p-6 drop-shadow-lg hover:w-5/12 duration-500 hover:rounded-2xl transition-all cursor-pointer select-none backdrop-blur-3xl bg-opacity-30 border-0.5 border-blue-700 overflow-hidden">
        <h1 class="text-2xl font-bold mb-4 text-blue-500"><strong>❄️</strong> Welcome, {{ $username }} !</h1>
        
        <ul class="text-white space-y-2">
          <li class="line-clamp-1 flex gap-2 overflow-hidden"><strong>User ID : </strong>{{ $id }}</li>
          <li class="line-clamp-1 flex gap-2 overflow-hidden"><strong>Username : </strong>{{ $username }}</li>
        </ul>
    </div>

</body>
</html>
