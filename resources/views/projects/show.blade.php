<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Task Manager</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet" />

        <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

        <link href="     https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/brands.min.css" />
        <link href="    https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/fontawesome.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.0/dist/alpine.min.js" defer></script>

        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
            integrity="sha512-3NDgm8En5yDN9qF8x6cSwpKXoJd/U1kK6Ma4McYAcj3PP5U5cF8NyM4NlbKQ3n8U9sGFAZR/w/lD1fxT8J2N2w=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />

        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
            integrity="sha512-3NDgm8En5yDN9qF8x6cSwpKXoJd/U1kK6Ma4McYAcj3PP5U5cF8NyM4NlbKQ3n8U9sGFAZR/w/lD1fxT8J2N2w=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
    </head>

    <body class="bg-gray-100 text-gray-900 flex">
        <div class="bg-white w-64 min-h-screen shadow-lg flex flex-col">
            <div class="p-6 flex items-center gap-2 border-b">
                <span class="text-xl font-bold text-gray-800">Task Monitor</span>
            </div>

            <div class="flex flex-col mt-4 space-y-2 flex-grow">
                <a href="{{ route('admin') }}" class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200"> <i class="fas fa-th-large"></i> Ana Sayfa </a>
                <a href="#" class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200"> <i class="fas fa-calendar-alt"></i> Takvim </a>
                <a href="{{ route('admin.users.create') }}" class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                    <i class="fa-solid fa-user-plus"></i> Kullanıcı Ekle
                </a>
                <a href="{{ route('admin.users.show') }}" class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200"> <i class="fa-solid fa-users"></i> Kullanıcılar </a>
                <a href="{{ route('admin.users.assaign') }}" class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200"> <i class="fa-solid fa-list-check"></i> Görev Ata </a>

                <a href="{{ route('admin.workSessions') }}"
                class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-green-50 hover:text-green-600 transition-colors duration-200">
                <i class="fa-solid fa-clock"></i> Mesai Takip
            </a>
        
        
                <a href="{{ route('projects.index') }}" class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200"> <i class="fa-solid fa-microchip"></i> Projeler </a>

                <a href="" class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200"> <i class="fa-solid fa-file-pen"></i> Raporlar </a>
            </div>

            <div class="p-4 bg-gray-100 mt-auto flex items-center gap-2 border-t">
                <div>
                    <div class="text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500">{{ Auth::user()->gorev }}</div>
                </div>
                <a href="{{ route('profile') }}" class="ml-auto text-gray-500 hover:text-gray-800 transition-colors duration-200">
                    <i class="fas fa-cog"></i>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="ml-2">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-gray-800 transition-colors duration-200">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>

     <style>

        /* Genel Stiller */ body { font-family: "Nunito", sans-serif; background-color: #f3f4f6; /* Tailwind'in cool gray-100 tonu */ color: #1f2937; /* Tailwind'in cool gray-900 tonu */ } /* Navbar Stilleri */ .sidebar { background-color:
        #1e40af; /* Tailwind'in indigo-800 tonu */ color: #ffffff; } .sidebar a { color: #ffffff; } .sidebar a:hover { background-color: #3b82f6; /* Tailwind'in blue-500 tonu */ color: #ffffff; } /* Sütun ve Kart Stilleri */ .column {
        min-height: 600px; background-color: #ffffff; border-radius: 10px; transition: background-color 0.3s ease, box-shadow 0.3s ease; } .column:hover { background-color: #f9fafb; /* Tailwind'in cool gray-50 tonu */ box-shadow: 0 4px 15px
        rgba(0, 0, 0, 0.1); } .task-card { background-color: #ffffff; border-radius: 8px; transition: transform 0.2s, box-shadow 0.2s; } .task-card:hover { transform: scale(1.05); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); } /* Kartların
        Durumlarına Göre Renkler */ .bg-atandi { background-color: #fee2e2; /* Red-100 */ } .bg-basladi { background-color: #fef3c7; /* Yellow-100 */ } .bg-devam-ediyor { background-color: #dbeafe; /* Blue-100 */ } .bg-test-ediliyor {
        background-color: #ffedd5; /* Orange-100 */ } .bg-tamamlandi { background-color: #d1fae5; /* Green-100 */ } /* Diğer Stiller */ .dragging { opacity: 0.5; } .task-card + .task-card { margin-top: 1rem; }

    </style>


<div class="container p-9">



    <div class="p-6">
        <button onclick="window.location.href='{{ route('admin.users.assaign') }}'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
            <i class="fa-solid fa-list-check"></i> Task Ata
        </button>
    </div>


    <div class="flex flex-wrap gap-3">
        <div class="column flex-1 p-4 bg-white rounded-lg shadow-lg min-w-[300px]" data-status="Atandı" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
            <h2 class="text-xl font-bold mb-4 text-red-600">Atandı</h2>
            @foreach ($project->tasks()->where('status', 'Atandı')->get() as $task)
                <div class="task-card bg-atandi p-4 mb-4 rounded-lg shadow-md" draggable="true" data-task-id="{{ $task->id }}" ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                    <h3 class="font-bold mb-2">{{ $task->title }}</h3>
                    <p class="text-sm text-gray-700 mb-1">Kime: {{ $task->assignedUser->name }}</p>
                    <p class="text-sm text-gray-700 mb-1">Atanma Tarihi: {{ $task->start_date }}</p>
                    <p class="text-sm text-gray-700 mb-1">Son Teslim Tarihi: {{ $task->due_date }}</p>
                    <p class="text-sm text-gray-700 mb-2">Görev İçeriği: {{ $task->description }}</p>
                    <p class="text-sm text-gray-700 mb-2">Proje İsmi: {{$project->name }}</p>

                    <p class="text-sm text-gray-700">
                        Ek Materyaller: @if ($task->attachments)
                            <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                        @else
                            Yok
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
        <div class="column flex-1 p-4 bg-white rounded-lg shadow-lg min-w-[300px]" data-status="basladi" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
            <h2 class="text-xl font-bold mb-4 text-yellow-600">Başladı</h2>
            @foreach ($project->tasks()->where('status', 'basladi')->get() as $task)
                <div class="task-card bg-basladi p-4 mb-4 rounded-lg shadow-md" draggable="true" data-task-id="{{ $task->id }}" ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                    <h3 class="font-bold mb-2">{{ $task->title }}</h3>
                    <p class="text-sm text-gray-700 mb-1">Kime: {{ $task->assignedUser->name }}</p>
                    <p class="text-sm text-gray-700 mb-1">Atanma Tarihi: {{ $task->start_date }}</p>
                    <p class="text-sm text-gray-700 mb-1">Son Teslim Tarihi: {{ $task->due_date }}</p>
                    <p class="text-sm text-gray-700 mb-2">Görev İçeriği: {{ $task->description }}</p>
                    <p class="text-sm text-gray-700 mb-2">Proje İsmi: {{$project->name }}</p>

                    <p class="text-sm text-gray-700">
                        Ek Materyaller: @if ($task->attachments)
                            <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                        @else
                            Yok
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
        <div class="column flex-1 p-4 bg-white rounded-lg shadow-lg min-w-[300px]" data-status="Devam Ediyor" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
            <h2 class="text-xl font-bold mb-4 text-blue-600">Devam Ediyor</h2>
            @foreach ($project->tasks()->where('status', 'Devam Ediyor')->get() as $task)
                <div class="task-card bg-devam-ediyor p-4 mb-4 rounded-lg shadow-md" draggable="true" data-task-id="{{ $task->id }}" ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                    <h3 class="font-bold mb-2">{{ $task->title }}</h3>
                    <p class="text-sm text-gray-700 mb-1">Kime: {{ $task->assignedUser->name }}</p>
                    <p class="text-sm text-gray-700 mb-1">Atanma Tarihi: {{ $task->start_date }}</p>
                    <p class="text-sm text-gray-700 mb-1">Son Teslim Tarihi: {{ $task->due_date }}</p>
                    <p class="text-sm text-gray-700 mb-2">Görev İçeriği: {{ $task->description }}</p>
                    <p class="text-sm text-gray-700 mb-2">Proje İsmi: {{$project->name }}</p>

                    <p class="text-sm text-gray-700">
                        Ek Materyaller: @if ($task->attachments)
                            <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                        @else
                            Yok
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
        <div class="column flex-1 p-4 bg-white rounded-lg shadow-lg min-w-[300px]" data-status="test ediliyor" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
            <h2 class="text-xl font-bold mb-4 text-orange-600">Test Ediliyor</h2>
            @foreach ($project->tasks()->where('status', 'test ediliyor')->get() as $task)
                <div class="task-card bg-test-ediliyor p-4 mb-4 rounded-lg shadow-md" draggable="true" data-task-id="{{ $task->id }}" ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                    <h3 class="font-bold mb-2">{{ $task->title }}</h3>
                    <p class="text-sm text-gray-700 mb-1">Kime: {{ $task->assignedUser->name }}</p>
                    <p class="text-sm text-gray-700 mb-1">Atanma Tarihi: {{ $task->start_date }}</p>
                    <p class="text-sm text-gray-700 mb-1">Son Teslim Tarihi: {{ $task->due_date }}</p>
                    <p class="text-sm text-gray-700 mb-2">Görev İçeriği: {{ $task->description }}</p>
                    <p class="text-sm text-gray-700 mb-2">Proje İsmi: {{$project->name }}</p>

                    <p class="text-sm text-gray-700">
                        Ek Materyaller: @if ($task->attachments)
                            <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                        @else
                            Yok
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
        <div class="column flex-1 p-4 bg-white rounded-lg shadow-lg min-w-[300px]" data-status="tamamlandi" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
            <h2 class="text-xl font-bold mb-4 text-green-600">Tamamlandı</h2>
            @foreach ($project->tasks()->where('status', 'Tamamlandı')->get() as $task)
                <div class="task-card bg-tamamlandi p-4 mb-4 rounded-lg shadow-md" draggable="true" data-task-id="{{ $task->id }}" ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                    <h3 class="font-bold mb-2">{{ $task->title }}</h3>
                    <p class="text-sm text-gray-700 mb-1">Kime: {{ $task->assignedUser->name }}</p>
                    <p class="text-sm text-gray-700 mb-1">Atanma Tarihi: {{ $task->start_date }}</p>
                    <p class="text-sm text-gray-700 mb-1">Son Teslim Tarihi: {{ $task->due_date }}</p>
                    <p class="text-sm text-gray-700 mb-2">Görev İçeriği: {{ $task->description }}</p>
                    <p class="text-sm text-gray-700 mb-2">Proje İsmi: {{$project->name }}</p>

                    <p class="text-sm text-gray-700">
                        Ek Materyaller: @if ($task->attachments)
                            <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                        @else
                            Yok
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</div>


<script>
    function handleDragStart(event) {
        event.dataTransfer.setData("text/plain", event.target.dataset.taskId);
        event.currentTarget.classList.add("dragging");
    }

    function handleDragEnd(event) {
        event.currentTarget.classList.remove("dragging");
    }

    function handleDrop(event) {
        event.preventDefault();
        const taskId = event.dataTransfer.getData("text/plain");
        const newStatus = event.currentTarget.dataset.status;
        const taskCard = document.querySelector(`[data-task-id='${taskId}']`);
        if (taskCard) {
            updateTaskStatus(taskId, newStatus);
        }
    }

    async function updateTaskStatus(taskId, newStatus) {
        try {
            const response = await fetch(`/tasks/${taskId}/update-status`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ status: newStatus })
            });

            if (response.ok) {
                console.log("Görev durumu güncellendi.");
                location.href = location.href;
            } else {
                location.href = location.href;
                
            }
        } catch (error) {
            location.href = location.href;
        }
    }
</script>


    </body>
</html>
