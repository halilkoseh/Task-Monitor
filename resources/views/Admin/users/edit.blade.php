@extends('layout.app')

@section('content')

<div class="container mx-auto p-4 mt-64">
    <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-md">
        <div class="p-4">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Adı Soyadı</label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                </div>

                <div class="mb-4">
                    <label for="gorev" class="block text-sm font-medium text-gray-700">Görevi</label>
                    <input type="text" name="gorev" id="gorev" value="{{ $user->gorev }}" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Güncelle</button>
                </div>
            </form>

            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="mt-4 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">Sil</button>
            </form>

            <div class="mt-4">
                <a href="{{ route('admin.users.show') }}" class="text-blue-500 hover:text-blue-800">Geri Dön</a>
            </div>
        </div>
    </div>
</div>

<script>
    const profileMenu = document.querySelector('.relative');
    profileMenu.addEventListener('mouseenter', function () {
        const submenu = this.querySelector('.absolute');
        submenu.classList.remove('hidden');
    });
    profileMenu.addEventListener('mouseleave', function () {
        const submenu = this.querySelector('.absolute');
        submenu.classList.add('hidden');
    });
</script>

@endsection
