<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Monitor</title>
    <meta name="description" content="Notifications Email Template">
    <style>
    </style>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">
    <div class="bg-gray-100 min-h-screen flex items-center justify-center">
        <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-indigo-600 text-white text-center py-4 px-6">
                <h2 class="text-2xl font-bold">Yeni Görev Bildirimi</h2>
            </div>

            <div class="px-6 py-8">
                <h1 class="text-2xl font-semibold text-gray-800 mb-6">Merhaba {{ $user->name }},</h1>
                <p class="text-base text-gray-600 mb-8">Senin için yeni bir görev atandı.</p>

                <div class="border-b border-gray-200 mb-8 pb-8">
                    <div class="flex items-center mb-6">

                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800 text-2xl">Görev Başlığı</h3>
                            <p class="text-lg text-gray-600">{{ $task->title }}</p>

                        </div>
                    </div>
                    <div class="flex items-center mb-6">

                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800 text-2xl">Görevin Açıklaması</h3>
                            <p class="text-md text-gray-600">{{ $task->description }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">

                        <div class="ml-4">
                            <h1 class="text-lg font-semibold text-gray-800 text-2xl">Atanan Proje</h1>
                            <p class="text-md text-gray-600">{{ $task->project->name }}</p>
                            <p class="text-md text-gray-600 mt-2">Görev detayları için lütfen uygulamamıza giriş
                                yapınız.</p>

                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="https://halilkose.me"
                            class="text-indigo-600 hover:text-indigo-700 font-medium underline">Uygulamaya Git</a>
                    </div>
                </div>

                <div class="text-center text-gray-600">
                    <p class="text-sm text-gray-600">Atama tarihi: {{ $task->start_date }} | Teslim tarihi:
                        {{ $task->due_date }}</p>
                    <p class="text-sm">&copy; <strong>www.mfeteknoloji.com</strong></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
