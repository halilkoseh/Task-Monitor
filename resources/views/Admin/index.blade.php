@extends('layout.app')

@section('content')
    <style>
        /* Genel Stiller */
        body {
            font-family: "Nunito", sans-serif;
            background-color: #f3f4f6; /* Tailwind'in cool gray-100 tonu */
            color: #1f2937; /* Tailwind'in cool gray-900 tonu */
        }

        /* Navbar Stilleri */
        .sidebar {
            background-color: #1e40af; /* Tailwind'in indigo-800 tonu */
            color: #ffffff;
        }

        .sidebar a {
            color: #ffffff;
        }

        .sidebar a:hover {
            background-color: #3b82f6; /* Tailwind'in blue-500 tonu */
            color: #ffffff;
        }

        /* Sütun ve Kart Stilleri */
        .column {
            min-height: 600px;
            background-color: #ffffff;
            border-radius: 10px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .column:hover {
            background-color: #f9fafb; /* Tailwind'in cool gray-50 tonu */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .task-card {
            background-color: #ffffff;
            border-radius: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .task-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Kartların Durumlarına Göre Renkler */
        .bg-atandi {
            background-color: #fee2e2; /* Red-100 */
        }

        .bg-basladi {
            background-color: #fef3c7; /* Yellow-100 */
        }

        .bg-devam-ediyor {
            background-color: #dbeafe; /* Blue-100 */
        }

        .bg-test-ediliyor {
            background-color: #ffedd5; /* Orange-100 */
        }

        .bg-tamamlandi {
            background-color: #d1fae5; /* Green-100 */
        }

        /* Diğer Stiller */
        .dragging {
            opacity: 0.5;
        }

        .task-card + .task-card {
            margin-top: 1rem;
        }
    </style>

    <div class="container p-9">
        <div class="flex flex-wrap gap-3">
            <!-- Atandı Sütunu -->
            <div class="column flex-1 p-4 bg-white rounded-lg shadow-lg min-w-[300px]" data-status="Atandı" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                <h2 class="text-xl font-bold mb-4 text-red-600">Atandı</h2>
                @foreach ($userTasks as $user)
                    @foreach ($user->tasks as $task)
                        @if ($task->status == 'Atandı')
                            <div class="task-card bg-atandi p-4 mb-4 rounded-lg shadow-md" draggable="true" data-task-id="{{ $task->id }}" ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                                <h3 class="font-bold mb-2">{{ $task->title }}</h3>
                                <p class="text-sm text-gray-700 mb-1">Kime: {{ $user->name }}</p>
                                <p class="text-sm text-gray-700 mb-1">Atanma Tarihi: {{ $task->start_date }}</p>
                                <p class="text-sm text-gray-700 mb-1">Son Teslim Tarihi: {{ $task->due_date }}</p>
                                <p class="text-sm text-gray-700 mb-2">Görev İçeriği: {{ $task->description }}</p>
                                <p class="text-sm text-gray-700 mb-2">Proje İsmi: {{ $task->projectName?->name  }}</p>

                                <p class="text-sm text-gray-700">
                                    Ek Materyaller: @if ($task->attachments)
                                        <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                                    @else
                                        Yok
                                    @endif
                                </p>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
            <!-- Başladı Sütunu -->
            <div class="column flex-1 p-4 bg-white rounded-lg shadow-lg min-w-[300px]" data-status="basladi" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                <h2 class="text-xl font-bold mb-4 text-yellow-600">Başladı</h2>
                @foreach ($userTasks as $user)
                    @foreach ($user->tasks as $task)
                        @if ($task->status == 'basladi')
                            <div class="task-card bg-basladi p-4 mb-4 rounded-lg shadow-md" draggable="true" data-task-id="{{ $task->id }}" ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                                <h3 class="font-bold mb-2">{{ $task->title }}</h3>
                                <p class="text-sm text-gray-700 mb-1">Kime: {{ $user->name }}</p>
                                <p class="text-sm text-gray-700 mb-1">Atanma Tarihi: {{ $task->start_date }}</p>
                                <p class="text-sm text-gray-700 mb-1">Son Teslim Tarihi: {{ $task->due_date }}</p>
                                <p class="text-sm text-gray-700 mb-2">Görev İçeriği: {{ $task->description }}</p>
                                <p class="text-sm text-gray-700 mb-2">Proje İsmi: {{ $task->projectName?->name  }}</p>

                                <p class="text-sm text-gray-700">
                                    Ek Materyaller: @if ($task->attachments)
                                        <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                                    @else
                                        Yok
                                    @endif
                                </p>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
            <!-- Devam Ediyor Sütunu -->
            <div class="column flex-1 p-4 bg-white rounded-lg shadow-lg min-w-[300px]" data-status="Devam Ediyor" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                <h2 class="text-xl font-bold mb-4 text-blue-600">Devam Ediyor</h2>
                @foreach ($userTasks as $user)
                    @foreach ($user->tasks as $task)
                        @if ($task->status == 'Devam Ediyor')
                            <div class="task-card bg-devam-ediyor p-4 mb-4 rounded-lg shadow-md" draggable="true" data-task-id="{{ $task->id }}" ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                                <h3 class="font-bold mb-2">{{ $task->title }}</h3>
                                <p class="text-sm text-gray-700 mb-1">Kime: {{ $user->name }}</p>
                                <p class="text-sm text-gray-700 mb-1">Atanma Tarihi: {{ $task->start_date }}</p>
                                <p class="text-sm text-gray-700 mb-1">Son Teslim Tarihi: {{ $task->due_date }}</p>
                                <p class="text-sm text-gray-700 mb-2">Görev İçeriği: {{ $task->description }}</p>
                                <p class="text-sm text-gray-700 mb-2">Proje İsmi: {{ $task->projectName?->name  }}</p>

                                <p class="text-sm text-gray-700">
                                    Ek Materyaller: @if ($task->attachments)
                                        <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                                    @else
                                        Yok
                                    @endif
                                </p>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
            <!-- Test Ediliyor Sütunu -->
            <div class="column flex-1 p-4 bg-white rounded-lg shadow-lg min-w-[300px]" data-status="test ediliyor" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                <h2 class="text-xl font-bold mb-4 text-orange-600">Test Ediliyor</h2>
                @foreach ($userTasks as $user)
                    @foreach ($user->tasks as $task)
                        @if ($task->status == 'test ediliyor')
                            <div class="task-card bg-test-ediliyor p-4 mb-4 rounded-lg shadow-md" draggable="true" data-task-id="{{ $task->id }}" ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                                <h3 class="font-bold mb-2">{{ $task->title }}</h3>
                                <p class="text-sm text-gray-700 mb-1">Kime: {{ $user->name }}</p>
                                <p class="text-sm text-gray-700 mb-1">Atanma Tarihi: {{ $task->start_date }}</p>
                                <p class="text-sm text-gray-700 mb-1">Son Teslim Tarihi: {{ $task->due_date }}</p>
                                <p class="text-sm text-gray-700 mb-2">Görev İçeriği: {{ $task->description }}</p>
                                <p class="text-sm text-gray-700 mb-2">Proje İsmi: {{ $task->projectName?->name  }}</p>

                                <p class="text-sm text-gray-700">
                                    Ek Materyaller: @if ($task->attachments)
                                        <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                                    @else
                                        Yok
                                    @endif
                                </p>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
            <!-- Tamamlandı Sütunu -->
            <div class="column flex-1 p-4 bg-white rounded-lg shadow-lg min-w-[300px]" data-status="tamamlandi" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                <h2 class="text-xl font-bold mb-4 text-green-600">Tamamlandı</h2>
                @foreach ($userTasks as $user)
                    @foreach ($user->tasks as $task)
                        @if ($task->status == 'tamamlandi')
                            <div class="task-card bg-tamamlandi p-4 mb-4 rounded-lg shadow-md" draggable="true" data-task-id="{{ $task->id }}" ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                                <h3 class="font-bold mb-2">{{ $task->title }}</h3>
                                <p class="text-sm text-gray-700 mb-1">Kime: {{ $user->name }}</p>
                                <p class="text-sm text-gray-700 mb-1">Atanma Tarihi: {{ $task->start_date }}</p>
                                <p class="text-sm text-gray-700 mb-1">Son Teslim Tarihi: {{ $task->due_date }}</p>
                                <p class="text-sm text-gray-700 mb-2">Görev İçeriği: {{ $task->description }}</p>
                                <p class="text-sm text-gray-700 mb-2">Proje İsmi: {{ $task->projectName?->name  }}</p>

                                <p class="text-sm text-gray-700">
                                    Ek Materyaller: @if ($task->attachments)
                                        <a href="{{ asset('storage/' . $task->attachments) }}" target="_blank">Dosyayı Görüntüle</a>
                                    @else
                                        Yok
                                    @endif
                                </p>
                            </div>
                        @endif
                    @endforeach
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
                    window.location.reload();
                } else {
                    console.error("Görev durumu güncellenirken hata oluştu.");
                }
            } catch (error) {
                console.error("Bir hata meydana geldi:", error);
            }
        }
    </script>
@endsection