<style>
.content-container {
    min-height: 100vh;
    margin-left: 16rem; 
    padding: 20px;
    box-sizing: border-box; 
}
</style>


@extends('layout.app')

@section('content')
<div class="content-container w-full">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Atanmış Tasklar</h2>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <ul class="space-y-4">
            @foreach ($tasks as $task)
                <li class=" bg-white shadow-md rounded-lg p-4 flex items-center justify-between">
                    <span class="text-lg font-medium">{{ $task->title }}</span>
                    <a href="{{ route('tasks.edit', $task->id) }}"
                        class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Düzenle </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>    
@endsection
