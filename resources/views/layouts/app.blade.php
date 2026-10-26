<!doctype html>
<html lang="km">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Smart Internship')</title>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{font-family:'Kantumruy Pro','Noto Sans Khmer',sans-serif}</style>
</head>
<body class="bg-gray-50 text-gray-800">
@auth
<div class="flex min-h-screen">
    <aside class="w-60 bg-white border-r p-4 flex flex-col">
        <div class="mb-6">
            <p class="font-semibold">Smart Internship</p>
            <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }} Panel</p>
        </div>
        @if(auth()->user()->isAdmin())
        @php
            $links = [
                ['admin.dashboard','ផ្ទាំងគ្រប់គ្រង'],
                ['admin.users','អ្នកប្រើប្រាស់'],
                ['admin.companies','ក្រុមហ៊ុន/ស្ថាប័ន'],
                ['admin.registrations','ការចុះឈ្មោះ'],
                ['admin.programs','កម្មវិធីកម្មសិក្សា'],
                ['admin.notifications','ការជូនដំណឹង'],
            ];
        @endphp
        <nav class="flex-1 space-y-1">
            @foreach($links as [$route,$label])
                <a href="{{ route($route) }}"
                   class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs($route) ? 'bg-blue-50 text-blue-800 font-medium' : 'hover:bg-gray-100' }}">{{ $label }}</a>
            @endforeach
        </nav>
        @endif
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="w-full text-left px-3 py-2 text-sm rounded-lg hover:bg-gray-100">ចេញ</button>
        </form>
    </aside>
    <main class="flex-1 p-6">
        @include('partials.flash')
        @yield('content')
    </main>
</div>
@else
<main class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        @include('partials.flash')
        @yield('content')
    </div>
</main>
@endauth
</body>
</html>
