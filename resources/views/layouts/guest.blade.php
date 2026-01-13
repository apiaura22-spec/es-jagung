<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Es Jagung Lumer') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-yellow-50 via-white to-orange-50">
            
            <div class="mb-4">
                @if (isset($logo))
                    {{ $logo }}
                @else
                    <a href="/" class="flex flex-col items-center group">
                        <div class="bg-white p-3 rounded-2xl shadow-sm group-hover:shadow-md transition-all border border-yellow-100">
                            <span class="text-4xl">🌽</span>
                        </div>
                    </a>
                @endif
            </div>

            <div class="w-full sm:max-w-md mt-2 px-2 py-4 overflow-hidden">
                {{ $slot }}
            </div>

            <div class="mt-8 text-gray-400 text-xs">
                &copy; {{ date('Y') }} Es Jagung Manis Viral 🍧
            </div>
        </div>
    </body>
</html>