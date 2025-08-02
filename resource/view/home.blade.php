<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Welcome to Frostel</title>
  <link rel="stylesheet" href="/resource/css/style.css">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <style>
    .snowflake {
      position: absolute;
      top: -10px;
      background: white;
      border-radius: 9999px;
      opacity: 0.8;
      pointer-events: none;
      transition: opacity 1s ease; /* smooth fade */
      opacity: 70%;
    }
    @keyframes fall {
      to {
        transform: translateY(100vh);
      }
    }
  </style>
</head>
<body class="bg-gradient-to-br from-blue-900 to-gray-900 text-white min-h-screen flex flex-col items-center justify-center p-6">
  <div class="max-w-2xl text-center">
    <div class="tracking-wide w-full flex justify-center items-center">
        <img id="frostel-img" src="/storage/img/Frostel.png" alt="Frostel.png" class="w-52 h-52 transition-all hover:rotate-180 duration-5000 hover:scale-75">
    </div>
    <h1 class="text-5xl font-extrabold mb-6 tracking-wide">Welcome to <span class="text-blue-400">Frostel</span></h1>
    <p class="text-lg text-gray-300 leading-relaxed">
      <strong class="text-white">lightweight MVC framework</strong> written in PHP and styled with Tailwind CSS
    </p>
    <p>
      It is designed to be <strong>fast</strong>, <strong>clean</strong>, and <strong>easy to extend</strong> for modern development
    </p>
  </div>
  <footer class="mt-16 text-sm text-gray-500">
    &copy; <?= date("Y") ?> Frostel Project. All rights reserved.
  </footer>

  <div id="snow-container" class="absolute inset-0 z-0 max-w-full max-h-full overflow-hidden pointer-events-none"></div>
  <script src="/resource/js/app.js"></script>
</body>
</html>
