<!-- resources/views/profile.blade.php -->

@extends('userLayout.app')



@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Profilim</h2>

    <div class="bg-white p-6 rounded shadow-md">
        <h3 class="text-xl font-semibold mb-4">Kullanıcı Bilgileri</h3>
        <p><strong>Adı:</strong> {{ $user->name }}</p>
        <p><strong>Kullanıcı Adı:</strong> {{ $user->username }}</p>
        <p><strong>Görev:</strong> {{ $user->gorev }}</p>
    </div>

    <div class="bg-white p-6 mt-6 rounded shadow-md">
        <h3 class="text-xl font-semibold mb-4">Parola Değiştir</h3>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.updatePassword') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="current_password" class="block text-gray-700">Mevcut Parola</label>
                <input type="password" id="current_password" name="current_password" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="new_password" class="block text-gray-700">Yeni Parola</label>
                <input type="password" id="new_password" name="new_password" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="new_password_confirmation" class="block text-gray-700">Yeni Parola (Tekrar)</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full p-2 border rounded" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Parolayı Güncelle</button>
        </form>
    </div>
</div>
@endsection
