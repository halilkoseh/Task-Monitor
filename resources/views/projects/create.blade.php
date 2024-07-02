@extends('layout.app')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-lg shadow-lg p-8 mt-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Proje Oluştur</h1>
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <div class="mb-5">
            <label for="name" class="block text-sm font-medium text-gray-700">Proje Adı</label>
            <input type="text" name="name" id="name" class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3" required>
        </div>
        <div class="mb-5">
            <label for="type" class="block text-sm font-medium text-gray-700">Proje Türü</label>
            <input type="text" name="type" id="type" class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3" required>
        </div>
        <div class="mb-5">
            <label for="description" class="block text-sm font-medium text-gray-700">Açıklama</label>
            <textarea name="description" id="description" rows="4" class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3"></textarea>
        </div>
        <div class="mb-5">
            <label for="users" class="block text-sm font-medium text-gray-700">Kullanıcılar</label>
            <select name="users[]" id="users" multiple class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3">
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-5">
            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg shadow-md hover:bg-indigo-700">Oluştur</button>
        </div>
    </form>
</div>
@endsection
