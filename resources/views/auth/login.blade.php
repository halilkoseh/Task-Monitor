<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Monitor</title>
    <link rel="icon" href="images/favLogo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-300 h-screen flex items-center justify-center"
    style="background-image: url('images/bg.jpg'); background-size: cover; background-position: center;">
    <div class="max-w-md w-full p-8  bg-gray-100 bg-opacity-50 rounded-lg shadow-lg border-black">
        <div class="max-w-md w-full p-8 bg-transparent rounded-lg shadow-lg ">
            <h1 class="text-4xl font-bold text-center mb-8 text-gray-600">Task Monitor</h1>
            <h2 class="text-2xl font-semibold text-center mb-8">
            </h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-6">
                    <label for="username" class="block text-sm font-medium text-gray-700">Kullanıcı Adı:</label>
                    <input type="text" id="username" name="username" required
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">Şifre:</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <button type="submit"
                    class="w-full bg-gray-600 text-white py-3 px-4 rounded-md hover:bg-gray-500 focus:outline-none focus:bg-gray-300 transition duration-150 ease-in-out">Giriş
                    Yap</button>
            </form>

            @if ($errors->any())
                <div class="mt-4">
                    @foreach ($errors->all() as $error)
                        <p class="text-md text-black text-items:center" >{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>
</body>

</html>
