@extends('layout.app')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Düzenle</h2>
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Başlık</label>
                <input type="text" name="title"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ $task->title }}">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Açıklama</label>
                <textarea name="description"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $task->description }}</textarea>
            </div>
            <div class="mb-4">
                <label for="due_date" class="block text-gray-700 text-sm font-bold mb-2">Son Tarih</label>
                <input type="date" name="due_date"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ $task->due_date }}">
            </div>
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Güncelle</button>
        </form>

        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Sil</button>
        </form>
    </div>
@endsection