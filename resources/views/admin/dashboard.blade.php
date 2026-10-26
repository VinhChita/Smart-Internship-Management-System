@extends('layouts.app')
@section('title','ផ្ទាំងគ្រប់គ្រង')
@section('content')
<h1 class="text-xl font-semibold mb-4">ផ្ទាំងគ្រប់គ្រង</h1>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['Intern សរុប',$stats['interns']],
        ['Supervisor',$stats['supervisors']],
        ['ក្រុមហ៊ុនដៃគូ',$stats['companies']],
        ['កម្មវិធីកំពុងបើក',$stats['programs']],
        ['រង់ចាំអនុម័ត',$stats['pending']],
        ['ពាក្យសុំរង់ចាំ',$stats['applications']],
        ['របាយការណ៍ថ្មី',$stats['reports']],
    ] as [$label,$value])
        <div class="bg-white border rounded-xl p-4">
            <p class="text-xs text-gray-500">{{ $label }}</p>
            <p class="text-2xl font-semibold mt-1">{{ $value }}</p>
        </div>
    @endforeach
</div>
<h2 class="font-medium mb-2">អ្នកប្រើប្រាស់ថ្មីៗ</h2>
<div class="bg-white border rounded-xl divide-y">
    @foreach($recentUsers as $u)
        <div class="p-3 flex justify-between text-sm">
            <span>{{ $u->name }} <span class="text-gray-400">· {{ $u->email }}</span></span>
            <span class="text-gray-500">{{ $u->role }} / {{ $u->status }}</span>
        </div>
    @endforeach
</div>
@endsection
