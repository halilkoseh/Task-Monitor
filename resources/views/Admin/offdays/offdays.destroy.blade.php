@extends('layout.app')

@section('content')

<div class="content-container bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold text-center mb-6">İzin Talebini Sil</h1>
        
        <p class="text-center text-lg mb-6">Bu izin talebini silmek istediğinizden emin misiniz?</p>

        <div class="flex justify-center">
            <a href="{{ route('offdays.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-gray-600">İptal</a>
            <form action="{{ route('offdays.destroy', $offday->id) }}" method="POST" class="ml-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-red-700">Sil</button>
            </form>
        </div>
    </div>
</div>

@endsection
