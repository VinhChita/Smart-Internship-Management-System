@extends('layouts.app')
@section('title','ទំព័រដើម')
@section('content')
<div class="bg-white rounded-2xl border p-8 text-center">
    <h1 class="text-lg font-semibold mb-2">សួស្តី {{ auth()->user()->name }}</h1>
    <p class="text-sm text-gray-600">តួនាទី: {{ ucfirst(auth()->user()->role) }}</p>
    <p class="text-sm text-gray-500 mt-4">សម្រាប់ Supervisor និង Intern សូមប្រើ Mobile App (REST API /api/*) ឬបន្ថែមទំព័រ Web តាមគំរូ Admin។</p>
    <form method="POST" action="{{ route('logout') }}" class="mt-6">@csrf
        <button class="px-4 py-2 border rounded-lg text-sm">ចេញ</button>
    </form>
</div>
@endsection
