@extends('layout.app')

@section('content')

<style>
    #calendar {
        max-width: 100%;
        margin: 0 auto;
    }
    .content-container {
        min-height: 100vh;
        padding: 20px;
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
        width: 500px;
    }

    .search-container .search-input {
        padding-left: 35px; 
    }

    .search-container .search-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }
</style>

<body class="bg-gray-100">

    <div class="content-container">
        <div class="flex justify-between items-center mb-8 p-2">
            <div class="search-container relative">
                <input type="text" placeholder="Ara.." class="search-input py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-blue-500 sm:text-sm w-full">
                <i class="fas fa-search search-icon"></i>
            </div>
            <div class="flex items-center space-x-4">
                <button class="text-red-200">
                    <i class="fas fa-bell"></i> 
                </button>
                <div class="user-info-container relative">
                    <div class="user-info">
                        <img src="{{ asset('images/profile.jpg') }}" alt="Profile Image">
                    </div>
                    <div class="ml-4 text-gray-800">{{ Auth::user()->name }}</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6">
            @php
                $colors = ['bg-blue-100', 'bg-pink-100', 'bg-yellow-100', 'bg-green-50', 'bg-red-50'];
            @endphp
            @foreach($projects->take(3) as $index => $project)
            @php
                $color = $colors[$index % count($colors)];
                $icon = $project->icon ?? 'project-diagram';
            @endphp
            <div class="card {{ $color }} col-span-12 sm:col-span-6 md:col-span-4 rounded-3xl shadow-lg p-6 transition duration-200 hover:shadow-xl relative">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-{{ $icon }} text-2xl text-gray-500"></i>
                    </div>
                    <div class="ml-4">
                        <a href="{{ route('projects.show', $project->id) }}" class="text-2xl text-blue-600 hover:underline font-semibold">{{ $project->name }}</a>
                        <p class="text-gray-500">{{ $project->type }}</p>
                    </div>
                </div>
                <p class="text-gray-700 mb-4">{{ $project->description }}</p>
                @if ($index == 2 && $projects->count() > 3)
                <div class="absolute top-2 right-2">
                    <a href="{{ route('projects.index') }}" class="text-blue-500 hover:text-blue-700">Tümünü Gör</a>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Activity and Schedule -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 mt-8">
            <!-- Chart Section -->
            <div class="card bg-white p-4 rounded-2xl shadow-md">
                <h3 class="text-xl">Aktif Olduğu Saat</h3>
                <div class="h-64">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
            <!-- Schedule Section -->
            <div class="card bg-white p-4 rounded-2xl shadow-md">
                <h3 class="text-xl">Günlük Görevler</h3>
                <div class="mt-4">
                    <p class="text-gray-600"><i class="fa-solid fa-file-code mr-2"></i>Proje İsmi - Araştırma İsmi</p>
                    <p class="text-gray-600"><i class="fa-solid fa-file-code mr-2"></i>Proje İsmi - Araştırma İsmi</p>
                    <p class="text-gray-600"><i class="fa-solid fa-file-code mr-2"></i>Proje İsmi - Araştırma İsmi</p>
                    <p class="text-gray-600"><i class="fa-solid fa-file-code mr-2"></i>Proje İsmi - Araştırma İsmi</p>
                </div>
            </div>
        </div>

        <!-- Calendar and Assignments -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Calendar Section -->
            <div class="card bg-white p-4 rounded-2xl shadow-md">
                <h3 class="text-xl">Takvim</h3>
                <div id="calendar"></div>
            </div>

            <!-- Work Situation Section -->
            <div class="card bg-white p-4 rounded-2xl shadow-md">
                <h3 class="text-xl">Mesai Durumu</h3>
                <div class="mt-4">
                    <div class="flex justify-between items-center bg-gray-100 p-2 rounded-lg mb-2">
                        <p class="text-gray-600">Başladı</p>
                        <span class="inline-block h-4 w-4 rounded-full status-indicator" data-status="started"></span>
                    </div>
                    <div class="flex justify-between items-center bg-gray-100 p-2 rounded-lg mb-2">
                        <p class="text-gray-600">Mola</p>
                        <span class="inline-block h-4 w-4 rounded-full status-indicator" data-status="break"></span>
                    </div>
                    <div class="flex justify-between items-center bg-gray-100 p-2 rounded-lg mb-2">
                        <p class="text-gray-600">Bitirdi</p>
                        <span class="inline-block h-4 w-4 rounded-full status-indicator" data-status="finished"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('activityChart').getContext('2d');
        var activityChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Kişi-1", "Kişi-2", "Kişi-3"],
                datasets: [{
                    label: 'Aktif Olduğu Saat Sayısı',
                    data: [55, 49, 44],
                    backgroundColor: [
                        "#b91d47",
                        "#00aba9",
                        "#2b5797"
                    ]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "Aktif Olduğu Saat Sayısı"
                }
            }
        });
    </script>

    <!-- FullCalendar -->
    <link href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@5.10.1/main.min.css' rel='stylesheet' />
    <link href='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.10.1/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@5.10.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.10.1/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [
                    {
                        title: 'Design Review',
                        start: '2024-07-10'
                    },
                    {
                        title: 'Sprint Planning',
                        start: '2024-07-11'
                    },
                    {
                        title: 'Project Deadline',
                        start: '2024-07-15'
                    }
                ]
            });
            calendar.render();
        });
    </script>

</body>
@endsection
