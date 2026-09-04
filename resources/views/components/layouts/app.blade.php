<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alkitab Literal</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body>

    <div class="bg-gray-800 text-gray-800 dark:bg-primary dark:text-gray-100 transition">
        {{ $slot }}
    </div>
    @livewireScripts

</body>

</html>
