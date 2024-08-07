@extends('layout.app')

@section('content')
    <div class="container-fluid mr-80  p-4 items-center w-1/2 mx-auto  ">


        <form action="{{ route('projects.update', $project->id) }}" method="POST"
            class="space-y-6 bg-white p-8 rounded-lg shadow-lg  ml-8 mt-32">
            @csrf
            @method('PUT')


            <div class="mt-6 mb-6">
                <a href="{{ route('projects.index') }}"
                    class="text-sky-500 hover:text-blue-800 transition-colors duration-200">
                    <i class="fa-solid fa-chevron-left"></i> Geri Dön
                </a>
            </div>
            <h1 class="text-3xl font-bold mb-6 flex justify-center mt-8">Proje Düzenle</h1>




            <div class="space-y-2">
                <label for="name" class="block text-gray-700 font-medium">Proje Adı</label>
                <input type="text" name="name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    value="{{ $project->name }}" required>
            </div>
            <div class="space-y-2">
                <label for="type" class="block text-gray-700 font-medium">Proje Türü</label>
                <input type="text" name="type"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    value="{{ $project->type }}" required>
            </div>
            <div class="space-y-2">
                <label for="description" class="block text-gray-700 font-medium">Açıklama</label>
                <textarea name="description"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:outline-none">{{ $project->description }}</textarea>
            </div>
            <button type="submit"
                class="w-full py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition duration-300">Güncelle</button>
        </form>
    </div>
@endsection
,
