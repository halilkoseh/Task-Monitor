
@extends('layout.app')

@section('content')


<div class="flex-1 p-8 mt-48">
    <div class="max-w-md mx-auto p-8 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-center mb-8">Kullanıcı Ekle</h1>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Ad:</label>
                <input type="text" id="name" name="name" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-gray-100 text-gray-900">
            </div>

            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Kullanıcı Adı:</label>
                <input type="text" id="username" name="username" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-gray-100 text-gray-900">
            </div>

            <div class="mb-4">
                <label for="gorev" class="block text-sm font-medium text-gray-700">Kullanıcı Görevi:</label>
                <input type="text" id="gorev" name="gorev" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-gray-100 text-gray-900">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Şifre:</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-gray-100 text-gray-900">
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Kullanıcı
                Ekle</button>
        </form>

        @if (session('success'))
        <p class="mt-4 text-green-500">{{ session('success') }}</p>
        @endif
    </div>
</div>



@endsection
