@extends('layouts.app')
@section('title','ចុះឈ្មោះ')
@section('content')
<div class="bg-white rounded-2xl border p-8">
    <h1 class="text-xl font-semibold text-center mb-6">ចុះឈ្មោះគណនីថ្មី</h1>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div><label class="text-sm text-gray-600">ឈ្មោះ</label>
            <input name="name" value="{{ old('name') }}" required class="mt-1 w-full border rounded-lg px-3 py-2"></div>
        <div><label class="text-sm text-gray-600">អុីមែល</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full border rounded-lg px-3 py-2"></div>
        <div><label class="text-sm text-gray-600">តួនាទី</label>
            <select name="role" class="mt-1 w-full border rounded-lg px-3 py-2">
                <option value="intern">Intern</option>
                <option value="supervisor">Supervisor</option>
            </select></div>
        <div><label class="text-sm text-gray-600">ពាក្យសម្ងាត់</label>
            <input type="password" name="password" required class="mt-1 w-full border rounded-lg px-3 py-2"></div>
        <div><label class="text-sm text-gray-600">បញ្ជាក់ពាក្យសម្ងាត់</label>
            <input type="password" name="password_confirmation" required class="mt-1 w-full border rounded-lg px-3 py-2"></div>
        <button class="w-full bg-blue-700 text-white rounded-lg py-2.5 font-medium">ចុះឈ្មោះ</button>
    </form>
    <p class="text-sm text-center mt-4"><a href="{{ route('login') }}" class="text-blue-700">ត្រឡប់ទៅចូលប្រើប្រាស់</a></p>
</div>
@endsection
