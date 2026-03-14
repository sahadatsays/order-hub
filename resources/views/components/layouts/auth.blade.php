@props([
    'title' => null,
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
</head>
<body class="h-full bg-white antialiased font-sans text-zinc-800">

<div class="flex h-full">

    {{-- Left decorative panel --}}
    <div class="hidden lg:flex lg:w-1/2 bg-zinc-950 text-white flex-col justify-between p-12">

        {{-- Logo --}}
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-9 h-9 rounded-full bg-indigo-600 shrink-0">
                <span class="text-white font-bold text-base leading-none">O</span>
            </div>
            <span class="text-white font-semibold text-lg tracking-tight">Order Hub</span>
        </div>

        {{-- Hero copy --}}
        <div class="space-y-8">
            <div class="space-y-4">
                <h1 class="text-4xl font-bold leading-tight tracking-tight text-white">
                    Manage your orders<br>with confidence.
                </h1>
                <p class="text-zinc-400 text-lg leading-relaxed max-w-sm">
                    A modern platform for teams who need clarity, speed, and control over their entire order workflow.
                </p>
            </div>

            <ul class="space-y-3">
                <li class="flex items-start gap-3">
                    <span class="mt-0.5 flex items-center justify-center w-5 h-5 rounded-full bg-indigo-600 shrink-0">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <span class="text-zinc-300 text-sm leading-relaxed">Real-time order tracking across all channels</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="mt-0.5 flex items-center justify-center w-5 h-5 rounded-full bg-indigo-600 shrink-0">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <span class="text-zinc-300 text-sm leading-relaxed">Automated fulfillment workflows and alerts</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="mt-0.5 flex items-center justify-center w-5 h-5 rounded-full bg-indigo-600 shrink-0">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <span class="text-zinc-300 text-sm leading-relaxed">Powerful analytics and reporting dashboards</span>
                </li>
            </ul>
        </div>

        {{-- Testimonial --}}
        <div class="border border-zinc-800 rounded-xl p-6 space-y-4">
            <p class="text-zinc-300 text-sm leading-relaxed italic">
                "Order Hub cut our processing time by 60%. It's the single tool our operations team relies on every day."
            </p>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-indigo-700 flex items-center justify-center shrink-0">
                    <span class="text-white text-xs font-semibold">SK</span>
                </div>
                <div>
                    <p class="text-white text-sm font-medium">Sarah K.</p>
                    <p class="text-zinc-500 text-xs">Operations Lead, Meridian Co.</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Right auth panel --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-sm">
            {{ $slot }}
        </div>
    </div>

</div>

</body>
</html>
