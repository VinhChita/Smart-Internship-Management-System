@extends('layouts.app')
@section('title','ការចុះឈ្មោះ')
@section('content')
<h1 class="text-xl font-semibold mb-4">ការចុះឈ្មោះរង់ចាំអនុម័ត</h1>
<div class="space-y-3">
    @forelse($users as $u)
        <div class="bg-white border rounded-xl p-4 flex items-center justify-between gap-4">
            <div>
                <p class="font-medium">{{ $u->name }} <span class="text-xs bg-blue-50 text-blue-800 px-2 py-0.5 rounded">{{ $u->role }}</span></p>
                <p class="text-xs text-gray-500">{{ $u->email }} · {{ $u->created_at->diffForHumans() }}</p>
            </div>
            <div class="flex gap-2">
                <form method="POST" action="{{ route('admin.registrations.reject',$u) }}">@csrf
                    <button class="px-3 py-1.5 border border-red-300 text-red-700 rounded-lg text-sm">បដិសេធ</button></form>
                <form method="POST" action="{{ route('admin.registrations.approve',$u) }}">@csrf
                    <button class="px-3 py-1.5 bg-green-700 text-white rounded-lg text-sm">អនុម័ត</button></form>
            </div>
        </div>
    @empty
        <p class="text-gray-500 text-sm">មិនមានការចុះឈ្មោះរង់ចាំទេ</p>
    @endforelse
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
