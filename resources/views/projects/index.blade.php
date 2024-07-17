@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl mb-6 mt-3">Projeler</h1>
    <a href="{{ route('projects.create') }}" class="inline-block mb-4 px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200 hover:transform hover:-translate-y-1 hover:shadow-lg">Proje Oluştur</a>
    @if($projects && count($projects) > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($projects as $index => $project)
        @php
            $colors = ['bg-blue-100', 'bg-pink-100', 'bg-yellow-100', 'bg-green-100', 'bg-red-100'];
            $color = $colors[$index % count($colors)];
            $icon = $project->icon ?? 'project-diagram';
        @endphp
        <div class="card {{ $color }} rounded-3xl shadow-lg p-6 transition duration-200 hover:shadow-xl">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-{{ $icon }} text-2xl text-gray-500"></i>
                </div>
                <div class="ml-4">
                    <a href="{{ route('projects.show', $project->id) }}" class="text-2xl text-blue-600 hover:underline font-semibold">{{ $project->name }}</a>
                    <p class="text-gray-500">{{ $project->type }}</p>
                </div>
            </div>
            <p class="text-gray-700 mb-4">{{ $project->description }}</p>
            <div class="flex justify-between mt-4">
                <a href="{{ route('projects.edit', $project->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition duration-200 hover:transform hover:-translate-y-1 hover:shadow-lg">Düzenle</a>
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Bu projeyi silmek istediğinize emin misiniz?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-block px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200 hover:transform hover:-translate-y-1 hover:shadow-lg">Sil</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p>Henüz proje yok.</p>
    @endif
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
