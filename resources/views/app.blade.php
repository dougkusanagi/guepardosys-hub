<!DOCTYPE html>
<html class="dark" style="scroll-behavior: smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="min-h-screen bg-blue-50 text-[#1f295a] font-roboto antialiased dark:bg-[#0D0C22] dark:text-slate-200"
    style="margin-bottom: 0 !important;">
    @inertia
</body>

</html>
