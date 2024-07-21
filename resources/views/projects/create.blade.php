<style>
.card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .content-container {
        min-height: 100vh;
        margin-left: 40rem; 
        padding: 20px;
        box-sizing: border-box; 
    }
    
</style>

@extends('layout.app')

@section('content')

<div class="content-container flex items-center justify-center min-h-screen p-5 box-border">
    <div class="max-w-lg w-full bg-white rounded-lg shadow-md p-8 mt-12">
        <h1 class="text-3xl font-semibold text-gray-600 mb-6">Proje Oluştur</h1>
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700">Proje Adı</label>
                <input type="text" name="name" id="name" class="mt-2 block w-full border border-gray-200 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3" required>
            </div>
            <div class="mb-5">
                <label for="type" class="block text-sm font-medium text-gray-700">Proje Türü</label>
                <input type="text" name="type" id="type" class="mt-2 block w-full border border-gray-200 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3" required>
            </div>
            <div class="mb-5">
                <label for="description" class="block text-sm font-medium text-gray-700">Açıklama</label>
                <textarea name="description" id="description" rows="4" class="mt-2 block w-full border border-gray-200 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3"></textarea>
            </div>



            <div class="mb-5">
                <label for="users" class="block text-sm font-medium text-gray-700">Kullanıcılar</label>
                <select name="users[]" id="users" multiple class="mt-2 block w-full border border-gray-200 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3">
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-5">
                <button type="submit" class="w-full bg-sky-600 text-white py-3 rounded-lg shadow-md hover:bg-indigo-700">Oluştur</button>
            </div>
        </form>
    </div>
</div>
@endsection
