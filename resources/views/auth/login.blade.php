<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://i.pinimg.com/originals/83/37/27/833727799b63e97bc88c47dea6159bd7.jpg');
            background-size: cover;
            background-position: center;
            font-family: 'Inter', sans-serif;
        }

        .icon {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
        }

        .input-container {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
        }

        .input-field {
            padding-left: 2.5rem;
        }
    </style>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="max-w-lg w-full p-12 bg-white rounded-lg shadow-lg">
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
        </div>
        <h1 class="text-3xl font-semibold text-center mb-8">Giriş Yap</h1>
        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4 input-container">
                <label for="username" class="sr-only">Kullanıcı Adı:</label>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 input-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 01-8 0m4 4v2m0-6V8a4 4 0 10-8 0v4m12 0v6m0-6V8a4 4 0 10-8 0v4" />
                </svg>
                <input type="text" id="username" name="username" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm input-field"
                    placeholder="Kullanıcı Adı">
            </div>

            <div class="mb-4 input-container">
                <label for="password" class="sr-only">Şifre:</label>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 input-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm input-field"
                    placeholder="Şifre">
            </div>

            <div class="flex items-center mb-8">
                <input id="remember_me" name="remember_me" type="checkbox"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">Beni Hatırla</label>
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-3 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600 text-lg mb-8">Giriş
                Yap</button>
        </form>

        @if ($errors->any())
        <div class="mt-4">
            @foreach ($errors->all() as $error)
            <p class="text-sm text-red-600">{{ $error }}</p>
            @endforeach
        </div>
        @endif
    </div>

    <script>
        // Beni Hatırla 
        document.addEventListener('DOMContentLoaded', function () {
            // gerektiğinde  geri yükleme
            const rememberMeCheckbox = document.getElementById('remember_me');
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');

            // LocalStorage'dan bilgileri kontrol et
            const storedUsername = localStorage.getItem('storedUsername');
            const storedPassword = localStorage.getItem('storedPassword');
            const rememberMeChecked = localStorage.getItem('rememberMeChecked');

            if (rememberMeChecked === 'true' && storedUsername && storedPassword) {
                usernameInput.value = storedUsername;
                passwordInput.value = storedPassword;
                rememberMeCheckbox.checked = true;
            }

            // Beni Hatırla 
            rememberMeCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    // Kullanıcı adı ve şifreyi LocalStorage'a kaydetme
                    localStorage.setItem('storedUsername', usernameInput.value);
                    localStorage.setItem('storedPassword', passwordInput.value);
                    localStorage.setItem('rememberMeChecked', true);
                } else {
                    // LocalStorage'daki bilgileri temizleme
                    localStorage.removeItem('storedUsername');
                    localStorage.removeItem('storedPassword');
                    localStorage.removeItem('rememberMeChecked');
                }
            });

            // Form submit olduğunda LocalStorage'daki değerleri temizleme
            const loginForm = document.getElementById('loginForm');
            loginForm.addEventListener('submit', function () {
                localStorage.removeItem('storedUsername');
                localStorage.removeItem('storedPassword');
                localStorage.removeItem('rememberMeChecked');
            });
        });
    </script>
</body>

</html>
