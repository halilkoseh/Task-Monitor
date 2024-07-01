@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Proje Düzenle</h1>
    <form action="{{ route('projects.update', $project->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="space-y-2">
            <label for="name" class="block text-gray-700">Proje Adı</label>
            <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200" value="{{ $project->name }}" required>
        </div>
        <div class="space-y-2">
            <label for="type" class="block text-gray-700">Proje Türü</label>
            <input type="text" name="type" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200" value="{{ $project->type }}" required>
        </div>
        <div class="space-y-2">
            <label for="description" class="block text-gray-700">Açıklama</label>
            <textarea name="description" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200">{{ $project->description }}</textarea>
        </div>
        <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Güncelle</button>
    </form>
</div>
@endsection
