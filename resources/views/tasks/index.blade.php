@extends('layout.app') @section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<style>
    html,
    body {
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
        padding: 5px;
        border-radius: 50%;
    }

    .search-icon {
        pointer-events: none; 
    }

    .user-info img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .search-container {
        position: relative;
        width: 100%;
        max-width: 500px;
    }

    .search-container .search-input {
        padding-left: 35px;
        width: 100%;
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
        background-color: #3a6ea5;
    }

    .bg-task {
        background-color: #ebebeb;
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
        color: #a0a0a0;
        margin-top: 10px;
    }

    .task-dates {
        font-size: 12px;
        color: #a0a0a0;
        text-align: left;
        margin-top: 10px;
    }

    .profile-picture {
        position: absolute;
        bottom: 10px;
        right: 10px;
        border-radius: 50%;
    }

    .dragging {
        opacity: 0.5;
    }

    .project-box {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        position: relative;
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
        color: #0284c7;
        text-decoration: underline;
        cursor: pointer;
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
    }

    .dropdown {
        position: relative;
        display: inline-block;
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

    .dropdown-content a,
    .dropdown-content form button {
        color: #000000;
        padding: 0.5rem 1rem;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    .dropdown-content a:hover,
    .dropdown-content form button:hover {
        background-color: #f1f1f1;
    }

    /* Custom light green colors */
    .bg-light-green-100 {
        background-color: #dcedc8;
    }

    .text-light-green-500 {
        color: #8bc34a;
    }

    .badge-light-green-100 {
        background-color: #dcedc8;
    }
</style>


<div class="content-container mx-auto">
    <div class="flex flex-wrap justify-between items-center mb-8 p-2">
        <div class="search-container relative ml-8 w-full sm:w-auto sm:flex-grow">
            <input
                type="text"
                id="user-search"
                placeholder="Kullanıcı, Proje veya Task Arayın..."
                class="search-input py-2 px-4 w-full border border-sky-500 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
            />
            <i class="fas fa-search search-icon absolute right-3 top-1/2 transform -translate-y-1/2"></i>
            <div id="suggestions" class="suggestions absolute bg-white border border-gray-300 rounded-lg mt-1 w-full hidden"></div>
        </div>

        <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 space-x-0 sm:space-x-8 w-full sm:w-auto mt-4 sm:mt-0">
            <span id="current-date" class="mr-4"></span>
            <div class="user-info-container relative">
                <a href="{{ route('profile') }}">
                    <div class="user-info flex items-center space-x-2">
                        @if (Auth::check())
                        <img class="w-10 h-10 rounded-full object-cover" src="{{ asset('images/' . Auth::user()->profilePic) }}" alt="{{ Auth::user()->name }}" />
                        @endif
                        <div id="greeting" class="text-gray-800"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script>
        document.querySelector(".search-input").addEventListener("input", function (e) {
            const query = e.target.value;

            if (query.length > 2) {
                fetch(`/admin/users/search?query=${query}`)
                    .then((response) => response.json())
                    .then((data) => {
                        const suggestions = document.getElementById("suggestions");
                        suggestions.innerHTML = "";
                        if (data.length > 0) {
                            data.forEach((item) => {
                                const suggestionItem = document.createElement("div");
                                suggestionItem.classList.add("suggestion-item", "p-2", "cursor-pointer", "hover:bg-gray-200");
                                suggestionItem.textContent = `${item.name} (${item.type})`;
                                suggestionItem.dataset.id = item.id;
                                suggestionItem.dataset.type = item.type;
                                suggestions.appendChild(suggestionItem);
                            });
                            suggestions.classList.remove("hidden");
                        } else {
                            suggestions.classList.add("hidden");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                    });
            } else {
                document.getElementById("suggestions").classList.add("hidden");
            }
        });

        document.getElementById("suggestions").addEventListener("click", function (e) {
            if (e.target.classList.contains("suggestion-item")) {
                const id = e.target.dataset.id;
                const type = e.target.dataset.type;

                if (type === "user") {
                    window.location.href = `/admin/users/show/`;
                } else if (type === "task") {
                    window.location.href = `/mission/index`;
                } else if (type === "project") {
                    window.location.href = `/projects/`;
                }
            }
        });

        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: "long",
                day: "numeric",
                month: "long",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit",
                second: "2-digit",
                hour12: false,
                timeZone: "Europe/Istanbul",
            };
            const formattedDate = now.toLocaleDateString("tr-TR", options);
            document.getElementById("current-date").textContent = formattedDate;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();

        function updateGreeting() {
            const now = new Date();
            const hours = now.getHours();
            let greeting;

            if (hours < 12) {
                greeting = "Günaydın";
            } else if (hours < 18) {
                greeting = "Tünaydın";
            } else {
                greeting = "İyi çalışmalar";
            }

            const userName = "{{ Auth::user()->name }}";
            document.getElementById("greeting").textContent = `${greeting}, ${userName}`;
        }

        updateGreeting();
    </script>

    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
            <div class="bg-white p-6 md:p-10 rounded-lg shadow-lg relative">
                <a href="{{ route('admin.users.show') }}" class="see-all-link absolute top-3 right-3 text-sky-500 hover:text-blue-600">
                    Tümünü Gör
                    <i class="fa-solid fa-angle-right"></i>
                </a>
                <h2 class="text-xl text-gray-600 font-semibold mb-2">Kullanıcılar</h2>
                <div class="flex flex-wrap -space-x-5 overflow-hidden py-6 ml-2">
                    @foreach ($users->take(4) as $user)

                    <img src="{{ asset('images/' . $user->profilePic) }}" alt="{{ $user->name }}" class="inline-block h-16 w-16 sm:h-24 sm:w-24 md:h-32 md:w-32 rounded-full ring-2 ring-gray-300 object-cover" />
                    @endforeach @if ($users->count() > 4)

                    <div class="inline-block h-16 w-16 sm:h-24 sm:w-24 md:h-32 md:w-32 rounded-full ring-2 ring-gray-300 bg-[#F1F5F9] flex items-center justify-center text-xs font-medium text-gray-700">
                        {{ $users->count() - 4 }}+
                    </div>
                    @endif
                </div>
            </div>

            @if ($projects && count($projects) > 0)

            <div class="relative">
                <div class="project-box bg-white rounded-md shadow-md p-4">
                    <a href="{{ route('projects.index') }}" class="see-all-link text-blue-600 hover:text-blue-700">
                        Tümünü Gör
                        <i class="fa-solid fa-angle-right"></i>
                    </a>
                    <h2 class="text-xl text-gray-600 font-semibold mt-3 ml-4">Projeler</h2>
                    @foreach ($projects->take(2) as $index => $project) @php $iconBackgroundColors = ['bg-sky-100', 'bg-green-100', 'bg-orange-100']; $iconColors = ['text-sky-500', 'text-green-500', 'text-orange-500']; $iconData = [ ['icon'
                    => 'fa-code'], ['icon' => 'fa-project-diagram'], ['icon' => 'fa-tasks'], ['icon' => 'fa-rocket'], ['icon' => 'fa-chart-network'], ['icon' => 'fa-clipboard-list'], ['icon' => 'fa-chart-pie'], ['icon' => 'fa-code-branch'],
                    ['icon' => 'fa-database'], ['icon' => 'fa-desktop'], ['icon' => 'fa-file-code'], ['icon' => 'fa-folder'], ['icon' => 'fa-laptop-code'], ['icon' => 'fa-microchip'], ['icon' => 'fa-mobile-alt'], ['icon' =>
                    'fa-network-wired'], ['icon' => 'fa-server'], ['icon' => 'fa-shield-alt'], ['icon' => 'fa-tablet-alt'], ]; $bgColor = $index == 1 ? 'bg-light-green-100' : $iconBackgroundColors[$index % count($iconBackgroundColors)];
                    $iconColor = $index == 1 ? 'text-light-green-500' : $iconColors[$index % count($iconColors)]; $icon = $iconData[$index % count($iconData)]; @endphp

                    <div class="project-card bg-white rounded-md shadow-sm mb-4 p-4 flex items-center space-x-4">
                        <div class="icon-container w-10 h-10 sm:w-12 sm:h-12 rounded-full {{ $bgColor }} flex items-center justify-center transform transition-transform duration-200 hover:scale-110">
                            <i class="fa-solid {{ $icon['icon'] }} text-sm sm:text-lg {{ $iconColor }}"></i>
                        </div>
                        <div class="text-container flex-1">
                            <a href="{{ route('projects.show', $project->id) }}" class="text-md sm:text-lg text-gray-600 hover:underline font-semibold">{{ $project->name }}</a>
                            <span class="badge mt-2 inline-block {{ $bgColor }} text-gray-600">{{ $project->type }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else

            <p>Henüz proje yok.</p>
            @endif
        </div>
        <div class="bg-transparent py-3 px-3">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl text-gray-600 font-semibold">Görevler</h2>
                <a href="{{ route('admin.users.assaign') }}">
                    <button id="add-task-btn" class="p-1 px-3 bg-sky-500 text-white text-sm rounded-full hover:bg-blue-500"><i class="fa-solid fa-circle-plus"></i> Görev Ata</button>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 task-board text-gray-600">
                @foreach (['Atandı', 'Başladı', 'Devam Ediyor', 'Test Ediliyor', 'Tamamlandı'] as $index => $status) @php $statusCount = $userTasks->pluck('tasks')->flatten()->where('status', $status)->count(); @endphp

                <div
                    class="p-4 rounded-lg shadow-lg min-h-[200px] md:min-h-[250px] lg:min-h-[300px] bg-white"
                    style="background-color: {{ ['#e0f2fe', '#dcedc8', '#ffedd5', '#e0f2fe', '#dcedc8'][$index % 5] }}"
                    data-status="{{ $status }}"
                    ondragover="event.preventDefault()"
                    ondrop="handleDrop(event)"
                >
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg md:text-xl font-semibold">{{ $status }}</h2>
                        <span class="bg-white text-gray-800 px-2 py-1 rounded-full shadow">{{ $statusCount }}</span>
                    </div>
                    @foreach ($userTasks as $user) @foreach ($user->tasks as $task) @if ($task->status == $status)

                    <div class="task-card p-4 mb-4 rounded-lg shadow-md relative bg-white" draggable="true" data-task-id="{{ $task->id }}" ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                        <div class="flex justify-end items-center">
                            <span class="badge {{ ['bg-orange-100', 'bg-[#dcedc8]', 'bg-sky-100'][$loop->index % 3] }} text-gray-600 py-1 px-2 rounded-lg mb-2 inline-block ml-auto">
                                {{ $task->assignedProject->name ?? 'Proje yok' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-semibold text-md sm:text-lg truncate max-w-xs">{{ $task->title }}</h3>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-500 hover:text-black transition">
                                    <i class="fa-solid fa-circle-info"></i>
                                </a>
                                <div class="dropdown">
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mb-4">
                            @if (strlen($task->description) > 200) {{ substr($task->description, 0, 200) }}... @else {{ $task->description }} @endif
                        </p>
                        <div class="task-dates text-sm text-gray-600 mb-4">
                            <p>{{ $task->start_date }} / {{ $task->due_date }}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-start">
                                <span class="italic font-light text-gray-400">{{ $user->name }}</span>
                                <img class="h-6 w-6 rounded-full ml-3" src="{{ asset('images/' . $user->profilePic) }}" alt="{{ $user->name }}" />
                            </div>
                            <div class="ml-4 space-x-2">
                                @if ($task->attachments)

                                <a href="{{ route('attachments.download', ['filename' => basename($task->attachments)]) }}" class="text-gray-600 hover:text-blue-500"><i class="fa-solid fa-paperclip"></i></a>
                                @endif @if ($task->document)

                                <a href="{{ route('document.download', ['filename' => basename($task->document)]) }}" class="text-gray-600 hover:text-blue-500"><i class="fa-solid fa-file-pdf"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="task-actions absolute top-2 right-2">
                        </div>
                    </div>
                    @endif @endforeach @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="attachmentModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fa-solid fa-paperclip text-blue-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Ek Materyaller</h3>
                            <div class="mt-2">
                                <ul id="attachmentList" class="list-disc pl-5">
                                    <!-- Attachments will be loaded here dynamically -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button
                        type="button"
                        onclick="closeAttachmentModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Kapat
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
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
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        status: newStatus,
                    }),
                });

                if (response.ok) {
                    console.log("Görev durumu güncellendi.");
                    window.location.reload();
                } else {
                    console.error("Görev durumu güncellenemedi.");
                    window.location.reload();
                }
            } catch (error) {
                console.error("Bir hata meydana geldi:", error);
                window.location.reload();
            }
        }

        document.addEventListener("click", function (event) {
            const dropdowns = document.querySelectorAll(".dropdown-content");
            dropdowns.forEach((dropdown) => {
                if (!dropdown.parentElement.contains(event.target)) {
                    dropdown.classList.remove("show");
                }
            });
        });

        window.toggleDropdown = function (button) {
            const dropdown = button.nextElementSibling;
            document.querySelectorAll(".dropdown-content").forEach((content) => {
                if (content !== dropdown) {
                    content.classList.remove("show");
                }
            });
            dropdown.classList.toggle("show");
        };

        window.openAttachmentModal = function (taskId) {
            fetch(`/tasks/${taskId}/attachments`)
                .then((response) => response.json())
                .then((attachments) => {
                    const attachmentList = document.getElementById("attachmentList");
                    attachmentList.innerHTML = ""; // Clear previous attachments

                    attachments.forEach((attachment) => {
                        const listItem = document.createElement("li");
                        const link = document.createElement("a");
                        link.href = attachment.url;
                        link.target = "_blank";
                        link.textContent = attachment.name;
                        listItem.appendChild(link);
                        attachmentList.appendChild(listItem);
                    });

                    document.getElementById("attachmentModal").classList.remove("hidden");
                })
                .catch((error) => console.error("Error fetching attachments:", error));
        };

        window.closeAttachmentModal = function () {
            document.getElementById("attachmentModal").classList.add("hidden");
        };

        // Attach event listeners for drag and drop
        document.querySelectorAll(".task-card").forEach((card) => {
            card.addEventListener("dragstart", handleDragStart);
            card.addEventListener("dragend", handleDragEnd);
        });

        document.querySelectorAll("[data-status]").forEach((column) => {
            column.addEventListener("dragover", (event) => event.preventDefault());
            column.addEventListener("drop", handleDrop);
        });
    });
</script>

@endsection
