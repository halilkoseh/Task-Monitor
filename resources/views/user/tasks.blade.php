@extends('userLayout.app')

@section('content')
<body class="flex">
    <style>
        /* Genel Stiller */
        body {
            font-family: "Nunito", sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
        }

        /* Navbar Stilleri */
        .sidebar {
            background-color: #1e40af;
            color: #ffffff;
        }

        .sidebar a {
            color: #ffffff;
        }

        .sidebar a:hover {
            background-color: #3b82f6;
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
            background-color: #f9fafb;
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
            background-color: #fee2e2;
        }

        .bg-basladi {
            background-color: #fef3c7;
        }

        .bg-devam-ediyor {
            background-color: #dbeafe;
        }

        .bg-test-ediliyor {
            background-color: #ffedd5;
        }

        .bg-tamamlandi {
            background-color: #d1fae5;
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
            @php
                $statuses = ['Atandı', 'basladi', 'Devam Ediyor', 'test ediliyor', 'tamamlandi'];
                $statusClasses = [
                    'Atandı' => 'bg-atandi',
                    'basladi' => 'bg-basladi',
                    'Devam Ediyor' => 'bg-devam-ediyor',
                    'test ediliyor' => 'bg-test-ediliyor',
                    'tamamlandi' => 'bg-tamamlandi'
                ];
                $statusColors = [
                    'Atandı' => 'text-red-600',
                    'basladi' => 'text-yellow-600',
                    'Devam Ediyor' => 'text-blue-600',
                    'test ediliyor' => 'text-orange-600',
                    'tamamlandi' => 'text-green-600'
                ];
            @endphp

            @foreach ($statuses as $status)
                <div class="column flex-1 p-4 bg-white rounded-lg shadow-lg min-w-[300px]" data-status="{{ $status }}" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                    <h2 class="text-xl font-bold mb-4 {{ $statusColors[$status] }}">{{ $status }}</h2>
                    @foreach ($userTasks as $task)
                        @if ($task->status == $status)
                            <div class="task-card {{ $statusClasses[$status] }} p-4 mb-4 rounded-lg shadow-md" draggable="true" data-task-id="{{ $task->id }}" ondragstart="handleDragStart(event)" ondragend="handleDragEnd(event)">
                                <h3 class="font-bold mb-2">{{ $task->title }}</h3>
                                <p class="text-sm text-gray-700 mb-1">Atanma Tarihi: {{ $task->start_date }}</p>
                                <p class="text-sm text-gray-700 mb-1">Son Teslim Tarihi: {{ $task->due_date }}</p>
                                <p class="text-sm text-gray-700 mb-2">Görev İçeriği: {{ $task->description }}</p>
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
                </div>
            @endforeach
        </div>
    </div>
</body>

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
