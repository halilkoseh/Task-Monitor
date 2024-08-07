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

            <form method="GET" action="{{ route('mission.index') }}"
                class="mb-4 flex space-x-4 justify-between items-center">

                <div>
                    <select name="owner_id" class="border rounded p-2">
                        <option value="">Tüm Kullanıcılar</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('owner_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}</option>
                        @endforeach
                    </select>
                    <input type="date" name="start_date" placeholder="Başlangıç Zamanı" class="border rounded p-2"
                        value="{{ request('start_date') }}">
                    <input type="date" name="end_date" placeholder="Bitiş Zamanı" class="border rounded p-2"
                        value="{{ request('end_date') }}">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Filtrele
                    </button>
                </div>
                <div>
                    <p class="text-lg"> <span class="font-bold">{{ $taskCount }}</span> task görüntüleniyor.</p>
                </div>
            </form>


            <ul class="space-y-4 items-center">
                @foreach ($tasks as $task)
                    <li class="bg-white shadow-md rounded-lg p-4 flex items-center justify-between">
                        <span class="text-lg font-medium">{{ $task->title }}</span>
                        <div class="flex items-center justify-center space-x-2">
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-4">
                                    Sil
                                </button>
                            </form>
                            <a href="{{ route('tasks.edit', $task->id) }}"
                                class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Düzenle
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
