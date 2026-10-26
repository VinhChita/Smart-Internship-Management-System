@extends('layouts.app')
@section('title','ការជូនដំណឹង')
@section('content')
<h1 class="text-xl font-semibold mb-4">ផ្ញើការជូនដំណឹង</h1>
<form method="POST" action="{{ route('admin.notifications.send') }}" class="bg-white border rounded-xl p-5 max-w-xl space-y-3">
    @csrf
    <select name="target" class="w-full border rounded-lg px-3 py-2">
        <option value="all">គ្រប់ User</option><option value="intern">Intern ទាំងអស់</option><option value="supervisor">Supervisor ទាំងអស់</option>
    </select>
    <input name="title" placeholder="ចំណងជើង" required class="w-full border rounded-lg px-3 py-2">
    <textarea name="body" rows="4" placeholder="ខ្លឹមសារ" class="w-full border rounded-lg px-3 py-2"></textarea>
    <button class="bg-blue-700 text-white rounded-lg px-5 py-2 text-sm">ផ្ញើ</button>
</form>
@endsection
