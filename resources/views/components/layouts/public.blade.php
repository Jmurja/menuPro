<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-center mb-6">
            <x-app-logo />
        </div>

        {{ $slot }}
    </div>

    @fluxScripts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</body>
</html>
