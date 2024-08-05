<style>
    /* Tailwind CSS ile daha çekici bir tasarım için stil eklemeleri */
    .content-container {
        min-height: 100vh;
        margin-left: 16rem;
        padding: 20px;
        box-sizing: border-box;
    }

    /* Shadow ve transition için eklemeler */
    .form-control {
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #4a90e2;
        /* Border rengini odaklanınca mavi yapmak için */
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
        /* Hafif gölge efekti */
    }
</style>

@extends('layout.app')

@section('content')
    <div class="content-container mx-auto p-6 bg-white rounded-lg shadow-xl">
        <div class="mt-6 mb-6">
            <a href="{{ route('mission.index') }}"
                class="text-sky-500 hover:text-blue-800 transition-colors duration-200">
                <i class="fa-solid fa-chevron-left"></i> Geri Dön
            </a>
        </div>
        <h2 class="text-4xl font-bold mb-6 text-gray-900">Görev Düzenle</h2>
        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="title" class="block text-gray-900 text-lg font-medium mb-2">Başlık</label>
                <input type="text" name="title" id="title"
                    class="form-control shadow-md border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ $task->title }}">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-900 text-lg font-medium mb-2">Açıklama</label>
                <textarea name="description" id="description"
                    class="form-control shadow-md border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400">{{ $task->description }}</textarea>
            </div>


            <div class="mb-4">
                <label for="start_date" class="block text-gray-900 text-lg font-medium mb-2">Başlangıç Tarih</label>
                <input type="date" name="start_date" id="start_date"
                    class="form-control shadow-md border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ $task->start_date }}">
            </div>





            <div class="mb-4">
                <label for="due_date" class="block text-gray-900 text-lg font-medium mb-2">Son Tarih</label>
                <input type="date" name="due_date" id="due_date"
                    class="form-control shadow-md border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ $task->due_date }}">
            </div>



            <div class="flex justify-between items-center">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400">Güncelle</button>

        </form>

        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="mt-6">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-400">Sil</button>
        </form>
    </div>
    </div>
@endsection
