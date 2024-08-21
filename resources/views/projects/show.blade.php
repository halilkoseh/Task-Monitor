<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <link rel="icon" type="image/x-icon" href="images/favLogo.png">

    <style>
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .sidebar-item {
            transition: all 0.3s, transform 0.3s;
            display: block;
            padding: 10px;
        }

        .sidebar-item:hover,
        .sidebar-item.active {
            background-color: #e0f2fe;
            color: #075985;
        }

        .logo-box {
            background-color: #0ea5e9;
            padding: 10px;
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .logo-box:hover {
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .sidebar {
                display: fixed;
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 100%;
                background: white;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                overflow-y: auto;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-toggle {
                display: block;
                font-size: 1.5rem;
                cursor: pointer;
                z-index: 1100;
                /* Ensure the toggle button is above other content */
            }
        }
    </style>
</head>

<body>
    <!-- Hamburger Menu -->
    <div class="lg:hidden p-4 relative">
        <span class="sidebar-toggle text-gray-600">
            <i class="fas fa-bars"></i>
        </span>
    </div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="sidebar fixed w-64 bg-white h-screen p-5 text-gray-600 rounded-xl md:w-1/4 lg:w-1/5 xl:w-1/6 ">

        <div class="flex items-center mb-20">
            <a href="{{ url('admin') }}" class="flex items-center">
                <div class="logo-box rounded-full">
                    <img src="{{ asset('images/logo1.png') }}" alt="logo" class="w-14" />
                </div>
            </a>
            <a href="{{ url('admin') }}" class="ml-2">
                <span class="font-quicksand text-2xl">Task Monitor</span>
            </a>
        </div>

        <ul id="sidebar-menu" class="space-y-4">
            <li>
                <a href="{{ route('admin') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fas fa-th-large mr-3"></i>
                    Admin Paneli
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.show') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-regular fa-id-card mr-3"></i>
                    Kullanıcılar
                </a>
            </li>
            <li>
                <a href="{{ route('projects.index') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-regular fa-file-code mr-4"></i>
                    Projeler
                </a>
            </li>
            <li>
                <a href="{{ route('mission.index') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-solid fa-layer-group mr-3"></i> Görevler
                </a>
            </li>
            <li>
                <a href="{{ route('admin.workSessions') }}"
                    class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-regular fa-clock mr-3"></i>
                    Mesai Takip
                </a>
            </li>
            <li>
                <a href="{{ route('admin.offdays.index') }}"
                    class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-regular fa-pen-to-square mr-3"></i>
                    İzin Takip
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reports.index') }}"
                    class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-regular fa-copy mr-3"></i>
                    Raporlar
                </a>
            </li>
        </ul>

        <div class="mt-40">
            <div class="flex flex-col justify-center mt-auto gap-1 border-t border-gray-500 pt-1">
                <a href="{{ route('profile') }}"
                    class="text-gray-600 hover:text-sky-700 transition-colors duration-200 flex items-center gap-2 pl-2">
                    <i class="fas fa-cog text-md mr-1"></i>
                    <span class="text-md">Ayarlar</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="flex items-center gap-4 pl-2">
                    @csrf
                    <button type="submit"
                        class="text-gray-600 hover:text-sky-700 transition-colors duration-200 flex items-center gap-2">
                        <i class="fas fa-sign-out-alt text-md mb-1 mr-1"></i>
                        <span class="text-md mb-1">Çıkış Yap</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarItems = document.querySelectorAll('.sidebar-item');

            sidebarItems.forEach(item => {
                item.addEventListener('click', function() {
                    sidebarItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            const currentUrl = window.location.href;
            sidebarItems.forEach(item => {
                if (item.href === currentUrl) {
                    item.classList.add('active');
                }
            });

            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.querySelector('.sidebar-toggle');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
            });

            document.addEventListener('click', function(e) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            });
        });
    </script>
</body>

</html>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.0/dist/alpine.min.js" defer></script>
    <style>
        .dragging {
            opacity: 0.5;
        }
    </style>
</head>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Board</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            box-sizing: border-box;

        }
        .container {
            margin-left: 10%;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
        }
        .header button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
        }
        .header button:hover {
            background-color: #0056b3;
        }
        .board {
            display: flex;
gap: 5px;
            overflow-x: auto;
            padding: 20px 0;
            flex-wrap: nowrap;
        }
        .column {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 250px;
            min-height: 500px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            flex-shrink: 0;
        }
        .column h2 {
            font-size: 18px;
            margin: 0 0 20px;
            color: #333;
        }
        .task-card {
            background: #f0f0f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: grab;
            transition: background-color 0.3s;
        }
        .task-card:hover {
            background-color: #e0e0e0;
        }
        .task-card .task-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .task-card .task-info {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }
        .task-card .task-info:last-child {
            margin-bottom: 0;
        }
        .dragging {
            opacity: 0.5;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .header button {
                font-size: 14px;
                padding: 8px 16px;
            }
            .board {
                flex-direction: column;
                overflow-x: visible;
            }
            .column {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body class="">
    <div class="container ml-32">
        <div class="header ml-32">
            <button onclick="window.location.href='{{ route('admin.users.assaign') }}'">
                <i class="fa-solid fa-list-check"></i> Task Ata
            </button>
        </div>
        <div class="board ml-32">
            <div class="column" data-status="Atandı" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                <h2 class="text-red-600">Atandı</h2>
                @foreach ($project->tasks()->where('status', 'Atandı')->get() as $task)
                    <div class="task-card bg-red-100" draggable="true" data-task-id="{{ $task->id }}"
                        ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                        <div class="task-title">{{ $task->title }}</div>
                        <div class="task-info">Kime: {{ $task->assignedUser->name }}</div>
                        <div class="task-info">Atanma Tarihi: {{ $task->start_date }}</div>
                        <div class="task-info">Son Teslim Tarihi: {{ $task->due_date }}</div>
                        <div class="task-info">Görev İçeriği: {{ $task->description }}</div>
                        <div class="task-info">Proje İsmi: {{ $project->name }}</div>
                        <div class="task-info">
                            Ek Materyaller: @if ($task->attachments)
                                <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                            @else
                                Yok
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Repeat for other columns with different statuses -->
            <div class="column" data-status="basladi" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                <h2 class="text-yellow-600">Başladı</h2>
                @foreach ($project->tasks()->where('status', 'basladi')->get() as $task)
                    <div class="task-card bg-yellow-100" draggable="true" data-task-id="{{ $task->id }}"
                        ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                        <div class="task-title">{{ $task->title }}</div>
                        <div class="task-info">Kime: {{ $task->assignedUser->name }}</div>
                        <div class="task-info">Atanma Tarihi: {{ $task->start_date }}</div>
                        <div class="task-info">Son Teslim Tarihi: {{ $task->due_date }}</div>
                        <div class="task-info">Görev İçeriği: {{ $task->description }}</div>
                        <div class="task-info">Proje İsmi: {{ $project->name }}</div>
                        <div class="task-info">
                            Ek Materyaller: @if ($task->attachments)
                                <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                            @else
                                Yok
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="column" data-status="Devam Ediyor" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                <h2 class="text-blue-600">Devam Ediyor</h2>
                @foreach ($project->tasks()->where('status', 'Devam Ediyor')->get() as $task)
                    <div class="task-card bg-blue-100" draggable="true" data-task-id="{{ $task->id }}"
                        ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                        <div class="task-title">{{ $task->title }}</div>
                        <div class="task-info">Kime: {{ $task->assignedUser->name }}</div>
                        <div class="task-info">Atanma Tarihi: {{ $task->start_date }}</div>
                        <div class="task-info">Son Teslim Tarihi: {{ $task->due_date }}</div>
                        <div class="task-info">Görev İçeriği: {{ $task->description }}</div>
                        <div class="task-info">Proje İsmi: {{ $project->name }}</div>
                        <div class="task-info">
                            Ek Materyaller: @if ($task->attachments)
                                <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                            @else
                                Yok
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="column" data-status="Test Ediliyor" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                <h2 class="text-orange-600">Test Ediliyor</h2>
                @foreach ($project->tasks()->where('status', 'test ediliyor')->get() as $task)
                    <div class="task-card bg-orange-100" draggable="true" data-task-id="{{ $task->id }}"
                        ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                        <div class="task-title">{{ $task->title }}</div>
                        <div class="task-info">Kime: {{ $task->assignedUser->name }}</div>
                        <div class="task-info">Atanma Tarihi: {{ $task->start_date }}</div>
                        <div class="task-info">Son Teslim Tarihi: {{ $task->due_date }}</div>
                        <div class="task-info">Görev İçeriği: {{ $task->description }}</div>
                        <div class="task-info">Proje İsmi: {{ $project->name }}</div>
                        <div class="task-info">
                            Ek Materyaller: @if ($task->attachments)
                                <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                            @else
                                Yok
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="column" data-status="Tamamlandı" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                <h2 class="text-green-600">Tamamlandı</h2>
                @foreach ($project->tasks()->where('status', 'Tamamlandı')->get() as $task)
                    <div class="task-card bg-green-100" draggable="true" data-task-id="{{ $task->id }}"
                        ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                        <div class="task-title">{{ $task->title }}</div>
                        <div class="task-info">Kime: {{ $task->assignedUser->name }}</div>
                        <div class="task-info">Atanma Tarihi: {{ $task->start_date }}</div>
                        <div class="task-info">Son Teslim Tarihi: {{ $task->due_date }}</div>
                        <div class="task-info">Görev İçeriği: {{ $task->description }}</div>
                        <div class="task-info">Proje İsmi: {{ $project->name }}</div>
                        <div class="task-info">
                            Ek Materyaller: @if ($task->attachments)
                                <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                            @else
                                Yok
                            @endif
                        </div>
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
                    body: JSON.stringify({
                        status: newStatus
                    })
                });

                if (response.ok) {
                    console.log("Görev durumu güncellendi.");
                    location.reload();
                } else {
                    console.error("Görev durumu güncellenemedi.");
                    location.reload();
                }
            } catch (error) {
                console.error("Bir hata oluştu:", error);
                location.reload();
            }
        }
    </script>
</body>
</html>

