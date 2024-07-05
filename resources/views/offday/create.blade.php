@extends('userLayout.app')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-extrabold mb-6 text-center text-indigo-600">Yeni İzin Talebi Oluştur</h1>
        
        <form action="{{ route('offday.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="space-y-1">
                <label for="reason" class="block text-sm font-medium text-gray-700">Mazeret:</label>
                <input type="text" id="reason" name="reason" required 
                       class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
            </div>
            
            <div class="space-y-1">
                <label for="document" class="block text-sm font-medium text-gray-700">Belge (opsiyonel):</label>
                <input type="file" id="document" name="document" 
                       class="block w-full text-sm text-gray-500 rounded-lg border border-gray-300 bg-white text-indigo-600 hover:bg-indigo-50 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            </div>
            
            <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                İzin Talebi Oluştur
            </button>
        </form>
    </div>
@endsection
