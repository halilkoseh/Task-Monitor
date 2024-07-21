@extends('layout.app')

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<style>
    html, body {
        margin: 0;
        padding: 0;
        width: 100%;
        overflow-x: hidden; 
    }

    .content-container {
        min-height: 100vh;
        margin-left: 16rem; 
        padding: 20px;
        box-sizing: border-box; 
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .user-info-container {
        display: flex;
        align-items: center;
        margin-left: auto; 
    }

    .user-info {
        display: flex;
        align-items: center;
        position: relative;
        background-color: #fff;
        padding: 5px;
        border-radius: 50%;
    }

    .user-info img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .search-container {
        position: relative;
        width: 100%;
        max-width: 500px;
    }

    .search-container .search-input {
        padding-left: 35px; 
        width: 100%; /* Genişliği tam yap */
    }

    .search-container .search-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }

    .text-stroke {
        -webkit-text-stroke: 1px black;
        text-stroke: 1px black;
    }

    .bg-sidebar {
        background-color: #3A6EA5;
    }

    .bg-task {
        background-color: #EBEBEB;
    }

    .task-card {
        background-color: #ffffff;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 10px;
        cursor: move;
        position: relative;
    }

    .badge {
        color: #4b5563; /* text-gray-600 */
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 12px;
        display: inline-block;
    }

    .task-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        color: #A0A0A0;
        margin-top: 10px;
    }

    .task-dates {
        font-size: 12px;
        color: #A0A0A0;
        text-align: left;
        margin-top: 10px;
    }

    .profile-picture {
        position: absolute;
        bottom: 10px;
        right: 10px;
        border-radius: 50%;
        border: 2px solid white;
    }

    .dragging {
        opacity: 0.5;
    }

    .project-box {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .project-card {
        display: flex;
        align-items: center;
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 1rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
    }

    .project-card .icon-container {
        flex: 0 0 auto;
        margin-right: 1rem;
    }

    .project-card .text-container {
        flex: 1 1 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .see-all-link {
        color: #0284c7; /* text-sky-500 */
        text-decoration: underline;
        cursor: pointer;
    }

    .dropdown {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        z-index: 1;
        background-color: #ffffff;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        border-radius: 0.25rem;
    }

    .dropdown.show .dropdown-content {
        display: block;
    }

    .dropdown-content a, .dropdown-content form button {
        color: #000000;
        padding: 0.5rem 1rem;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    .dropdown-content a:hover, .dropdown-content form button:hover {
        background-color: #f1f1f1;
    }
</style>

<body class="bg-gray-100">

    <!-- Main Content -->
    <div class="content-container mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 p-2">
            <div class="search-container relative">
                <input type="text" placeholder="Ara.." class="search-input py-2 px-4 border border-sky-500 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <i class="fas fa-search search-icon"></i>
            </div>
            <div class="flex items-center space-x-4">
                <span id="current-date" class="mr-4">{{ \Carbon\Carbon::now()->locale('tr')->isoFormat('D MMMM YYYY') }}</span>
                <div class="user-info-container relative">
                    <div class="user-info">
                        <img src="{{ asset('images/profile.jpg') }}" alt="Profile Image">
                    </div>
                    <div class="ml-4 text-gray-800">Hoşgeldin, {{ Auth::user()->name }}</div>
                </div>
            </div>
        </div>

        
        <div class="container mx-auto p-4">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="bg-white p-10 rounded-lg shadow-lg relative">
                    <a href="{{ route('admin.users.show') }}" class="see-all-link absolute top-2 right-2 text-sky-500 hover:text-blue-600">Tümünü Gör</a>
                    <h2 class="text-xl text-gray-600 font-semibold mb-5">Tüm Kullanıcılar</h2>
                    <div class="flex -space-x-2 overflow-hidden">
                        @foreach ($users->take(10) as $user)
                            <img src="{{ $user->profile_photo_url }}" class="inline-block h-10 w-10 rounded-full ring-2 ring-white">
                        @endforeach
                        @if ($users->count() > 10)
                            <div class="inline-block h-10 w-10 rounded-full ring-2 ring-white bg-gray-300 flex items-center justify-center text-xs font-medium text-gray-700">
                                +{{ $users->count() - 10 }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white p-10 rounded-lg shadow-lg relative">
                    <a href="{{ route('projects.index') }}" class="see-all-link absolute top-2 right-2 text-sky-500 hover:text-blue-600">Tümünü Gör</a>
                    @if($projects && count($projects) > 0)
                    <div class="relative">
                        <div class="project-box">
                            <h2 class="text-xl text-gray-600 font-semibold">Projeler</h2>
                            @foreach($projects->take(3) as $index => $project)
                            @php
                                $iconBackgroundColors = ['bg-orange-100', 'bg-purple-100', 'bg-sky-100'];
                                $iconColors = ['text-orange-600', 'text-purple-500', 'text-sky-500'];
                                $iconData = [
                                    ['icon' => 'fa-code'],
                                    ['icon' => 'fa-project-diagram'],
                                    ['icon' => 'fa-tasks'],
                                ];
                                $bgColor = $iconBackgroundColors[$index % count($iconBackgroundColors)];
                                $iconColor = $iconColors[$index % count($iconColors)];
                                $icon = $iconData[$index % count($iconData)];
                            @endphp
                            <div class="project-card">
                                <div class="icon-container w-7 h-7 rounded-full {{ $bgColor }} flex items-center justify-center transform transition-transform duration-200 hover:scale-110">
                                    <i class="fa-solid {{ $icon['icon'] }} text-xs {{ $iconColor }}"></i>
                                </div>
                                <div class="text-container">
                                    <div>
                                        <a href="{{ route('projects.show', $project->id) }}" class="text-lg text-gray-600 hover:underline font-semibold">{{ $project->name }}</a>
                                    </div>
                                    <div>
                                        <span class="badge {{ $bgColor }} text-gray-600">{{ $project->type }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <p>Henüz proje yok.</p>
                    @endif
                </div>
            </div>

            <div class="bg-transparent py-3 px-3">
            <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl text-gray-600 font-semibold">Görevler</h2>
                <a href="{{ route('admin.users.assaign') }}">
                    <button id="add-task-btn" class="p-1 px-3 bg-sky-500 text-white text-sm rounded-full hover:bg-blue-500"><i class="fa-solid fa-circle-plus"></i> Görev Ata</button>
                </a>
                </div>
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 task-board text-gray-600">
                @foreach (['Atandı', 'Başladı', 'Devam Ediyor', 'Test Ediliyor', 'Tamamlandı'] as $index => $status)
                    <div class="p-4 rounded-lg shadow-lg min-h-[300px]" style="background-color: {{ ['#e0f2fe', '#f3e8ff', '#ffedd5', '#e0f2fe', '#f3e8ff'][$index % 5] }}" data-status="{{ $status }}" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                        <h2 class="text-xl font-semibold mb-4">{{ $status }}</h2>
                        @foreach ($userTasks as $user)
                            @foreach ($user->tasks as $task)
                                @if ($task->status == $status)
                                    <div class="task-card p-4 mb-4 rounded-lg shadow-md" draggable="true" data-task-id="{{ $task->id }}" ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                                        <h3 class="font-semibold mb-2">{{ $task->title }}</h3>
                                        <span class="badge {{ ['bg-orange-100', 'bg-purple-100', 'bg-sky-100'][$index % 3] }} text-gray-600">{{ $task->projectName?->name }}</span>
                                        <p class="text-sm text-gray-700 mb-1">Görev İçeriği: {{ $task->description }}</p>
                                        <div class="task-dates">
                                            <p>{{ $task->start_date }} / {{ $task->due_date }}</p>
                                        </div>
                                        <img src="{{ $user->profile_photo_url }}" class="profile-picture h-6 w-6">
                                        <div class="dropdown">
                                            <button class="text-gray-300 focus:outline-none dropdown-button">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <div class="dropdown-content">
                                                <a href="{{ route('tasks.edit', $task->id) }}">Düzenle</a>
                                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Bu görevi silmek istediğinize emin misiniz?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit">Sil</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                @endforeach
            </div>
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
            event.currentTarget.appendChild(taskCard);
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
            } else {
                console.error("Görev durumu güncellenemedi.");
            }
        } catch (error) {
            console.error("Bir hata meydana geldi:", error);
        }
    }


    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.dropdown-content');
        dropdowns.forEach(dropdown => {
            if (!dropdown.parentElement contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    });

    document.querySelectorAll('.dropdown-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation();
            const dropdown = this.nextElementSibling;
            document.querySelectorAll('.dropdown-content').forEach(content => {
                if (content !== dropdown) {
                    content.classList.remove('show');
                }
            });
            dropdown.classList.toggle('show');
        });
    });
</script>

@endsection
