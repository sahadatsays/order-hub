@props([
    'title' => null,
    'subtitle' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title . ' — Order Hub' : 'Order Hub' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $head ?? '' }}
</head>
<body class="h-full bg-zinc-50 antialiased font-sans text-zinc-800">

<div id="app-wrapper" class="flex min-h-screen">

    {{-- Mobile sidebar overlay --}}
    <div
        id="sidebar-overlay"
        class="hidden fixed inset-0 bg-zinc-900/50 z-20 lg:hidden"
        data-sidebar-toggle
    ></div>

    {{-- Sidebar --}}
    <x-app.sidebar />

    {{-- Main content area — offset by sidebar width on large screens --}}
    <div class="flex flex-col min-h-screen min-w-0 lg:ml-64 flex-1">

        {{-- Topbar --}}
        <x-app.topbar :title="$title" :subtitle="$subtitle ?? null" />

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-6">
            {{ $slot }}
        </main>

    </div>

    {{-- Toast container --}}
    <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2 w-80"></div>

</div>

@stack('scripts')

</body>
</html>
