@extends('layout.app')

@section('content')
    <div class=" mx-auto p-6 bg-white rounded-lg shadow-xl mt-32  ">
        <div class="mt-6 mb-6">
            <a href="{{ route('mission.index') }}" class="text-sky-500 hover:text-blue-800 transition-colors duration-200">
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


            <div class="flex justify-between items-center">

                <div class="mb-4">
                    <label for="start_date"
                        class="block text-gray-900 text-lg font-medium mb-2 flex justify-center">Başlangıç Tarih</label>
                    <input type="date" name="start_date" id="start_date"
                        class="form-control shadow-md border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ $task->start_date }}">
                </div>





                <div class="mb-4 ml-8">
                    <label for="due_date"
                        class="block text-gray-900 text-lg font-medium mb-2 items-center  flex justify-center">Son
                        Tarih</label>
                    <input type="date" name="due_date" id="due_date"
                        class="form-control shadow-md border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ $task->due_date }}">
                </div>
            </div>



            <div class="flex justify-end items-center ">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400">Güncelle</button>
            </div>

        </form>






    </div>
    </div>
@endsection
