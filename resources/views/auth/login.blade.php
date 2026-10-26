@extends('layouts.app')
@section('title','ចូលប្រើប្រាស់')
@section('content')
<div class="bg-white rounded-2xl border p-8">
    <h1 class="text-xl font-semibold text-center mb-1">Smart Internship</h1>
    <p class="text-sm text-gray-500 text-center mb-6">Management System</p>
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="text-sm text-gray-600">អុីមែល</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="text-sm text-gray-600">ពាក្យសម្ងាត់</label>
            <input type="password" name="password" required class="mt-1 w-full border rounded-lg px-3 py-2">
        </div>
        <button class="w-full bg-blue-700 text-white rounded-lg py-2.5 font-medium">ចូលប្រើប្រាស់</button>
    </form>
    <p class="text-sm text-center mt-4">មិនទាន់មានគណនី? <a href="{{ route('register') }}" class="text-blue-700 font-medium">ចុះឈ្មោះ</a></p>
</div>
@endsection
