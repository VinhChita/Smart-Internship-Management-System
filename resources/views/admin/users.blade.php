@extends('layouts.app')
@section('title','អ្នកប្រើប្រាស់')
@section('content')
<h1 class="text-xl font-semibold mb-4">អ្នកប្រើប្រាស់</h1>

<form method="GET" class="flex gap-2 mb-4">
    <input name="q" value="{{ request('q') }}" placeholder="ស្វែងរក..." class="border rounded-lg px-3 py-2 flex-1">
    <select name="role" class="border rounded-lg px-3 py-2">
        <option value="">គ្រប់ Role</option>
        @foreach(['admin','supervisor','intern'] as $r)
            <option value="{{ $r }}" @selected(request('role')===$r)>{{ $r }}</option>
        @endforeach
    </select>
    <button class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">ស្វែងរក</button>
</form>

<details class="mb-4 bg-white border rounded-xl p-4">
    <summary class="cursor-pointer text-sm font-medium text-blue-700">+ បន្ថែមអ្នកប្រើប្រាស់</summary>
    <form method="POST" action="{{ route('admin.users.store') }}" class="grid md:grid-cols-4 gap-3 mt-3">
        @csrf
        <input name="name" placeholder="ឈ្មោះ" required class="border rounded-lg px-3 py-2">
        <input type="email" name="email" placeholder="អុីមែល" required class="border rounded-lg px-3 py-2">
        <input type="password" name="password" placeholder="ពាក្យសម្ងាត់" required class="border rounded-lg px-3 py-2">
        <select name="role" class="border rounded-lg px-3 py-2">
            <option>intern</option><option>supervisor</option><option>admin</option>
        </select>
        <button class="md:col-span-4 bg-blue-700 text-white rounded-lg py-2 text-sm">រក្សាទុក</button>
    </form>
</details>

<div class="bg-white border rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs">
            <tr><th class="text-left p-3">ឈ្មោះ</th><th class="text-left p-3">តួនាទី</th><th class="text-left p-3">អុីមែល</th><th class="text-left p-3">ស្ថានភាព</th><th class="p-3"></th></tr>
        </thead>
        <tbody>
        @foreach($users as $u)
            <tr class="border-t">
                <td class="p-3">{{ $u->name }}</td>
                <td class="p-3">{{ $u->role }}</td>
                <td class="p-3 text-gray-500">{{ $u->email }}</td>
                <td class="p-3">{{ $u->status }}</td>
                <td class="p-3 text-right">
                    <form method="POST" action="{{ route('admin.users.destroy',$u) }}" onsubmit="return confirm('លុប?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 text-xs">លុប</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
