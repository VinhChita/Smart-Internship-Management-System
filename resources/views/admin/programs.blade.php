@extends('layouts.app')
@section('title','កម្មវិធីកម្មសិក្សា')
@section('content')
<h1 class="text-xl font-semibold mb-4">កម្មវិធីកម្មសិក្សា</h1>
<details class="mb-4 bg-white border rounded-xl p-4">
    <summary class="cursor-pointer text-sm font-medium text-blue-700">+ បង្កើតកម្មវិធីថ្មី</summary>
    <form method="POST" action="{{ route('admin.programs.store') }}" class="grid md:grid-cols-3 gap-3 mt-3">
        @csrf
        <input name="title" placeholder="ចំណងជើង" required class="border rounded-lg px-3 py-2">
        <select name="company_id" required class="border rounded-lg px-3 py-2">
            @foreach($companies as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
        </select>
        <input name="field" placeholder="ផ្នែក (IT, Marketing...)" class="border rounded-lg px-3 py-2">
        <input type="number" name="slots" value="1" min="1" class="border rounded-lg px-3 py-2">
        <input type="date" name="deadline" required class="border rounded-lg px-3 py-2">
        <select name="status" class="border rounded-lg px-3 py-2">
            <option value="draft">សេចក្តីព្រាង</option><option value="open">កំពុងបើក</option><option value="closed">បានបិទ</option>
        </select>
        <textarea name="description" placeholder="ពិពណ៌នា" class="md:col-span-3 border rounded-lg px-3 py-2"></textarea>
        <button class="md:col-span-3 bg-blue-700 text-white rounded-lg py-2 text-sm">រក្សាទុក</button>
    </form>
</details>
<div class="bg-white border rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs">
            <tr><th class="text-left p-3">ចំណងជើង</th><th class="text-left p-3">ក្រុមហ៊ុន</th><th class="text-left p-3">ផុតកំណត់</th><th class="text-left p-3">ស្ថានភាព</th><th class="p-3">ដាក់ពាក្យ</th><th class="p-3"></th></tr>
        </thead>
        <tbody>
        @foreach($programs as $p)
            <tr class="border-t">
                <td class="p-3 font-medium">{{ $p->title }}</td>
                <td class="p-3 text-gray-500">{{ $p->company->name }}</td>
                <td class="p-3 text-gray-500">{{ $p->deadline->format('d/m/Y') }}</td>
                <td class="p-3">{{ $p->status }}</td>
                <td class="p-3 text-center">{{ $p->applications_count }}</td>
                <td class="p-3 text-right">
                    <form method="POST" action="{{ route('admin.programs.destroy',$p) }}" onsubmit="return confirm('លុប?')">
                        @csrf @method('DELETE')<button class="text-red-600 text-xs">លុប</button></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $programs->links() }}</div>
@endsection
