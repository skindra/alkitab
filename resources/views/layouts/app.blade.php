<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <title>Alkitab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="bg-gray-100 text-gray-800 dark:bg-primary dark:text-gray-100 transition">
    {{ $slot }}
    @livewireScripts
</body>

</html>
