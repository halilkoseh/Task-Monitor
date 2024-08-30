<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">
    <title>User Form</title>
    <style>
        .main-content {
            margin-top: 2rem;
        }

        @media (min-width: 768px) {
            .main-content {
                margin-left: 16rem;
                padding: 2rem;
                box-sizing: border-box;
            }
        }
    </style>
</head>

<body>
    @extends('layout.app')

    @section('content')
        <div class="main-content flex-1 p-4 sm:p-8 lg:p-16">
            <div class="max-w-4xl mx-auto bg-white rounded-lg overflow-hidden shadow-md">
                <div class="p-6">
                    <div class="mt-6 mb-6">
                        <a href="{{ route('admin.users.show') }}" class="text-blue-500 hover:text-blue-800">
                            <i class="fa-solid fa-chevron-left"></i> Geri Dön
                        </a>
                    </div>

                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST"
                        class="grid grid-cols-1 gap-6" id="updateForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700">Adı Soyadı</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}"
                                placeholder="Adı Soyadı"
                                class="form-input mt-1 block w-full h-12 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required />
                        </div>

                        <div class="col-span-1">
                            <label for="gorev" class="block text-sm font-medium text-gray-700">Görevi</label>
                            <input type="text" name="gorev" id="gorev" value="{{ $user->gorev }}"
                                placeholder="Görevi"
                                class="form-input mt-1 block w-full h-12 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required />
                        </div>

                        <div class="col-span-1">
                            <label for="username" class="block text-sm font-medium text-gray-700">Kullanıcı Adı</label>
                            <input type="text" name="username" id="username" value="{{ $user->username }}"
                                placeholder="Kullanıcı Adı"
                                class="form-input mt-1 block w-full h-12 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required />
                        </div>

                        <div class="col-span-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Şifre</label>
                            <input type="password" name="password" id="password" placeholder="Şifre"
                                class="form-input mt-1 block w-full h-12 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required />
                            <span id="password-error" class="text-red-500 text-sm hidden">Bu alan boş bırakılamaz.</span>
                        </div>

                        <script>
                            const passwordInput = document.getElementById('password');
                            const passwordError = document.getElementById('password-error');

                            passwordInput.addEventListener('input', () => {
                                if (passwordInput.value.trim() === '') {
                                    passwordError.classList.remove('hidden');
                                } else {
                                    passwordError.classList.add('hidden');
                                }
                            });

                            document.querySelector('form').addEventListener('submit', (event) => {
                                if (passwordInput.value.trim() === '') {
                                    event.preventDefault();
                                    passwordError.classList.remove('hidden');
                                    passwordInput.focus();
                                }
                            });
                        </script>


                        <div class="col-span-1">
                            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}"
                                placeholder="E-mail"
                                class="form-input mt-1 block w-full h-12 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required />
                        </div>

                        <div class="col-span-1">
                            <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Telefon
                                Numarası</label>
                            <input type="tel" name="phoneNumber" id="phoneNumber" value="{{ $user->phoneNumber }}"
                                placeholder="Telefon Numarası"
                                class="form-input mt-1 block w-full h-12 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required />
                        </div>

                        <div class="col-span-1">
                            <label for="linkedinAddress" class="block text-sm font-medium text-gray-700">LinkedIn
                                Adresi</label>
                            <input type="url" name="linkedinAddress" id="linkedinAddress"
                                value="{{ $user->linkedinAddress }}" placeholder="LinkedIn Adresi"
                                class="form-input mt-1 block w-full h-12 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required />
                        </div>

                        <div class="col-span-1">
                            <label for="portfolioLink" class="block text-sm font-medium text-gray-700">Portföy
                                Adresi</label>
                            <input type="url" name="portfolioLink" id="portfolioLink" value="{{ $user->portfolioLink }}"
                                placeholder="Portföy Adresi"
                                class="form-input mt-1 block w-full h-12 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required />
                        </div>

                        <div class="mb-4 col-span-1">
                            <label for="profilePic" class="block text-sm font-medium text-gray-700">Profil Resmi:</label>
                            <input type="file" id="profilePic" name="profilePic" accept="*"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white text-gray-900"
                                required />
                        </div>


                    </form>

                    <div class="col-span-1 flex flex-col sm:flex-row justify-end items-center mt-8 gap-4">
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" id="deleteForm"
                            onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            @if ($user->name !== 'admin')
                                <button type="submit" form="deleteForm"
                                    class="px-4 py-2 text-red-400 hover:text-black rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 border-2 border-red-400">
                                    Sil
                                </button>
                            @endif
                        </form>
                        <button type="submit" form="updateForm"
                            class="px-4 py-2 text-white bg-blue-400 hover:text-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 border-2 border-blue-400">
                            Güncelle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</body>

</html>
