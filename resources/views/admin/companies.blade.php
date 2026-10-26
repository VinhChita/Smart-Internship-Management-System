@extends('layouts.app')
@section('title','ក្រុមហ៊ុន')
@section('content')
<h1 class="text-xl font-semibold mb-4">ក្រុមហ៊ុន/ស្ថាប័ន</h1>
<details class="mb-4 bg-white border rounded-xl p-4">
    <summary class="cursor-pointer text-sm font-medium text-blue-700">+ បន្ថែមក្រុមហ៊ុន</summary>
    <form method="POST" action="{{ route('admin.companies.store') }}" class="grid md:grid-cols-4 gap-3 mt-3">
        @csrf
        <input name="name" placeholder="ឈ្មោះក្រុមហ៊ុន" required class="border rounded-lg px-3 py-2">
        <input name="address" placeholder="អាសយដ្ឋាន" class="border rounded-lg px-3 py-2">
        <input name="contact_email" placeholder="អុីមែល" class="border rounded-lg px-3 py-2">
        <input name="contact_phone" placeholder="ទូរស័ព្ទ" class="border rounded-lg px-3 py-2">
        <button class="md:col-span-4 bg-blue-700 text-white rounded-lg py-2 text-sm">រក្សាទុក</button>
    </form>
</details>
<div class="bg-white border rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs">
            <tr><th class="text-left p-3">ឈ្មោះ</th><th class="text-left p-3">អាសយដ្ឋាន</th><th class="text-left p-3">ទំនាក់ទំនង</th><th class="p-3">កម្មវិធី</th><th class="p-3"></th></tr>
        </thead>
        <tbody>
        @foreach($companies as $c)
            <tr class="border-t">
                <td class="p-3 font-medium">{{ $c->name }}</td>
                <td class="p-3 text-gray-500">{{ $c->address }}</td>
                <td class="p-3 text-gray-500">{{ $c->contact_email }} {{ $c->contact_phone }}</td>
                <td class="p-3 text-center">{{ $c->programs_count }}</td>
                <td class="p-3 text-right">
                    <form method="POST" action="{{ route('admin.companies.destroy',$c) }}" onsubmit="return confirm('លុប?')">
                        @csrf @method('DELETE')<button class="text-red-600 text-xs">លុប</button></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $companies->links() }}</div>
@endsection
