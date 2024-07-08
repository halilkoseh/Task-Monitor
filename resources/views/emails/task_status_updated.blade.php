<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Görev Durumu Güncellendi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md mx-auto">
        <h1 class="text-2xl font-bold text-center mb-4">Görev Durumu Güncellendi</h1>
        <p class="text-gray-700 text-center mb-4">{{ $task->title }} adlı görevin durumu güncellendi.</p>
        <p class="text-center">
            <span class="font-semibold">Yeni durum:</span>
            <span class="text-blue-500">{{ $task->status }}</span>
        </p>
    </div>
</body>
</html>
