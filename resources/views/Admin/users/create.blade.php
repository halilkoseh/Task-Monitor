@extends('layout.app')

@section('content')
    <div class="flex-1 p-8 mt-24">
        <div class="max-w-4xl mx-auto p-8 bg-white rounded-lg shadow-lg">
            <div class="mt-6 mb-6">
                <a href="{{ route('admin.users.show') }}" class="text-blue-500 hover:text-blue-800"><i class="fa-solid fa-chevron-left"></i> Geri Dön</a>
            </div>
            <h1 class="text-3xl font-semibold text-center mb-8">Kullanıcı Ekle</h1>

           
            <form id="userForm" action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">İsim Soyisim:</label>
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
                        <input type="text" id="gorev" name="gorev"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-gray-100 text-gray-900">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Şifre:</label>
                        <input type="password" id="password" name="password" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-gray-100 text-gray-900">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">E-posta Adresi:</label>
                        <input type="email" id="email" name="email" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-gray-100 text-gray-900">
                    </div>

                    <div class="mb-4">
                        <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Telefon:</label>
                        <input type="tel" id="phoneNumber" name="phoneNumber"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-gray-100 text-gray-900">
                    </div>

                    <div class="mb-4">
                        <label for="linkedinAddress" class="block text-sm font-medium text-gray-700">LinkedIn Adresi:</label>
                        <input type="url" id="linkedinAddress" name="linkedinAddress"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-gray-100 text-gray-900">
                    </div>

                    <div class="mb-4">
                        <label for="portfolioLink" class="block text-sm font-medium text-gray-700">Portföy Adresi:</label>
                        <input type="url" id="portfolioLink" name="portfolioLink"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-gray-100 text-gray-900">
                    </div>

                    <div class="mb-4 md:col-span-2">
                        <label for="profilePic" class="block text-sm font-medium text-gray-700">Profil Resmi:</label>
                        <input type="file" id="profilePic" name="profilePic" accept="*"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white text-gray-900">
                    </div>
                    
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Kullanıcı
                    Ekle</button>
            </form>

            @if($errors->any())
                <div class="mt-4 text-red-500">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <p class="mt-4 text-green-500">{{ session('success') }}</p>
            @endif
        </div>
    </div>
@endsection