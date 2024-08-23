<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="images/favLogo.png">

    <style>
        .sidebar {
            background-color: #ffffff;
            color: #000000;
            width: 250px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, width 0.3s;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .sidebar a {
            color: #000000;
            display: block;
            padding: 0.75rem;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #f3f4f6;
        }

        .sidebar-item.active {
            background-color: #e0f2fe;
            color: #075985;
        }

        .sidebar-item:hover {
            background-color: #f3f4f6;
        }

        .main-content {
            margin-left: 250px;
            padding: 1rem;
            transition: margin-left 0.3s;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .column {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            min-width: 250px;
            margin: 0.5rem;
            transition: background-color 0.3s;
        }

        .column h2 {
            margin-bottom: 1rem;
        }

        .task-card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .task-card:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .hamburger {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                width: 100%;
                transform: translateX(-100%);
            }

            .sidebar.visible {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .hamburger {
                display: block;
                position: fixed;
                top: 1rem;
                left: 1rem;
                font-size: 1.5rem;
                z-index: 10;
                cursor: pointer;
                color: #000000;
            }
        }
    </style>
</head>

<body class="flex flex-col min-h-screen bg-gray-100 font-sans">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <div class="flex items-center mb-8">
            <a href="{{ url('user') }}" class="flex items-center">
                <div class="logo-box rounded-full">
                    <img src="{{ asset('images/favLogo.png') }}" alt="logo" class="w-14" />
                </div>
            </a>
            <a href="{{ url('user') }}" class="ml-2">
                <span class="text-2xl font-semibold">Task Monitor</span>
            </a>
        </div>

        <ul id="sidebar-menu" class="space-y-4">
            <li>
                <a href="{{ route('user') }}" class="sidebar-item flex items-center text-lg">
                    <i class="fas fa-th-large mr-3"></i>
                    Kullanıcı Paneli
                </a>
            </li>
            <li>
                <a href="{{ route('user.workSessions') }}" class="sidebar-item flex items-center text-lg">
                    <i class="fa-regular fa-clock mr-3"></i>
                    Mesai Giriş Çıkış
                </a>
            </li>
            <li>
                <a href="{{ route('offday.index') }}" class="sidebar-item flex items-center text-lg">
                    <i class="fa-regular fa-pen-to-square mr-3"></i>
                    İzin Talep
                </a>
            </li>
        </ul>

        <div class="mt-auto border-t border-gray-300 pt-4">
            <a href="{{ route('userProfile') }}"
                class="flex items-center gap-2 text-gray-600 hover:text-sky-700 transition-colors duration-200 pl-2">
                <i class="fas fa-cog text-md mr-1"></i>
                <span>Ayarlar</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="flex items-center gap-2 pl-2">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 text-gray-600 hover:text-sky-700 transition-colors duration-200">
                    <i class="fas fa-sign-out-alt text-md mr-1"></i>
                    <span>Çıkış Yap</span>
                </button>
            </form>
        </div>
    </div>

    <div class="hamburger" id="hamburger-menu">
        <i class="fas fa-bars"></i>
    </div>

    <div id="main-content" class="main-content">
        <div class="flex flex-wrap gap-4">
            @php
                $statuses = ['Atandı', 'basladi', 'Devam Ediyor', 'test ediliyor', 'tamamlandi'];
                $statusClasses = [
                    'Atandı' => 'bg-red-100',
                    'basladi' => 'bg-yellow-100',
                    'Devam Ediyor' => 'bg-blue-100',
                    'test ediliyor' => 'bg-orange-100',
                    'tamamlandi' => 'bg-green-100',
                ];
                $statusColors = [
                    'Atandı' => 'text-red-600',
                    'basladi' => 'text-yellow-600',
                    'Devam Ediyor' => 'text-blue-600',
                    'test ediliyor' => 'text-orange-600',
                    'tamamlandi' => 'text-green-600',
                ];
            @endphp

            @foreach ($statuses as $status)
                <div class="column" data-status="{{ $status }}" ondragover="event.preventDefault()"
                    ondrop="handleDrop(event)">
                    <h2 class="text-xl font-bold {{ $statusColors[$status] }}">{{ $status }}</h2>
                    @foreach ($userTasks as $task)
                        @if ($task->status == $status)
                            <div class="task-card {{ $statusClasses[$status] }}" draggable="true"
                                data-task-id="{{ $task->id }}" ondragstart="handleDragStart(event)"
                                ondragend="handleDragEnd(event)">
                                <h3 class="font-bold">{{ $task->title }}</h3>
                                <p class="text-sm text-gray-600">Atanma Tarihi: {{ $task->start_date }}</p>
                                <p class="text-sm text-gray-600">Son Teslim Tarihi: {{ $task->due_date }}</p>
                                <p class="text-sm text-gray-600">Görev İçeriği: {{ $task->description }}</p>
                                <p class="text-sm text-gray-600">
                                    Ek Materyaller: @if ($task->attachments)
                                        <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank"
                                            class="text-blue-500">Dosyayı Görüntüle</a>
                                    @else
                                        Yok
                                    @endif
                                </p>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            const sidebar = document.getElementById('sidebar');
            const hamburgerMenu = document.getElementById('hamburger-menu');
            const mainContent = document.getElementById('main-content');

            sidebarItems.forEach(item => {
                item.addEventListener('click', function() {
                    sidebarItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            hamburgerMenu.addEventListener('click', function() {
                sidebar.classList.toggle('visible');
                mainContent.classList.toggle('expanded');
            });

            const currentUrl = window.location.href;
            sidebarItems.forEach(item => {
                if (item.href === currentUrl) {
                    item.classList.add('active');
                }
            });
        });

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
                    window.location.reload();
                } else {
                    console.error("Görev durumu güncellenirken hata oluştu.");
                }
            } catch (error) {
                console.error("Bir hata meydana geldi:", error);
            }
        }
    </script>
</body>

</html>
