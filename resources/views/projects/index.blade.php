@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Projeler</h1>
    <a href="{{ route('projects.create') }}" class="inline-block mb-4 px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">Proje Oluştur</a>
    <ul class="space-y-4">
        @foreach($projects as $project)
        <li class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition duration-200">
            <a href="{{ route('projects.show', $project->id) }}" class="text-2xl text-blue-600 hover:underline font-semibold">{{ $project->name }}</a>
            <div class="text-gray-500 mt-2">{{ $project->type }}</div>
            <p class="text-gray-700 mt-2">{{ $project->description }}</p>
            <div class="flex gap-4 mt-4">
                <a href="{{ route('projects.edit', $project->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition duration-200">Düzenle</a>
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Bu projeyi silmek istediğinize emin misiniz?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-block px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">Sil</button>
                </form>

            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection
