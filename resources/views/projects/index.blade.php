@extends('layout.app')

@section('content')
    <style>
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .content-container {
            min-height: 100vh;
            margin-left: 16rem;
            padding: 20px;
            box-sizing: border-box;
        }

        .dropdown-content {
            display: none;
        }

        .dropdown-content.show {
            display: block;
        }
    </style>

    <div class="container content-container">
        <div class="flex justify-between items-center mx-auto p-4">
            <h1 class="text-3xl mb-6 mt-3 text-gray-600"><i class="fa-solid fa-code text-sky-500"></i> Projeler</h1>
            <a href="{{ route('projects.create') }}" class="inline-block mb-4 px-6 py-2 bg-sky-500 text-white rounded-full hover:bg-blue-500 transition duration-200"><i class="fa-solid fa-circle-plus"></i> Proje Oluştur</a>
        </div>
        
        <div class="flex justify-end items-center mx-auto p-4">
            <p class="text-md text-gray-600 underline">{{ count($projects) }} proje görüntüleniyor..</p>
        </div>

        @if($projects && count($projects) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($projects as $index => $project)
            @php
                $iconBackgroundColors = ['bg-sky-100', 'bg-[#dcedc8]', 'bg-orange-100'];
                $iconColors = ['text-sky-500', 'text-green-500', 'text-orange-500'];
                $iconData = [
                    ['icon' => 'fa-code'],
                    ['icon' => 'fa-project-diagram'],
                    ['icon' => 'fa-tasks'],
                    ['icon' => 'fa-rocket'],
                    ['icon' => 'fa-clipboard-list'],
                    ['icon' => 'fa-chart-pie'],
                    ['icon' => 'fa-code-branch'],
                    ['icon' => 'fa-database'],
                    ['icon' => 'fa-desktop'],
                    ['icon' => 'fa-file-code'],
                    ['icon' => 'fa-folder'],
                    ['icon' => 'fa-laptop-code'],
                    ['icon' => 'fa-microchip'],
                    ['icon' => 'fa-mobile-alt'],
                    ['icon' => 'fa-network-wired'],
                    ['icon' => 'fa-server'],
                    ['icon' => 'fa-shield-alt'],
                    ['icon' => 'fa-tablet-alt'],
                ];
                $bgColor = $iconBackgroundColors[$index % count($iconBackgroundColors)];
                $iconColor = $iconColors[$index % count($iconColors)];
                $icon = $iconData[$index % count($iconData)];
            @endphp
            <div class="card bg-white rounded-xl shadow-sm p-6 transition duration-200 hover:shadow-xl relative">
                <div class="dropdown absolute top-2 right-2 mr-1 mt-1">
                    <button class="text-gray-300 focus:outline-none dropdown-toggle">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <div class="dropdown-content absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-10">
                        <a href="{{ route('projects.edit', $project->id) }}" class="block px-4 py-2 text-blue-600 hover:bg-blue-100">Düzenle</a>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Bu projeyi silmek istediğinize emin misiniz?');" class="block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100">Sil</button>
                        </form>
                    </div>
                </div>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full {{ $bgColor }} flex items-center justify-center transform transition-transform duration-200 hover:scale-110">
                        <i class="fa-solid {{ $icon['icon'] }} text-md {{ $iconColor }}"></i>
                    </div>
                    <div class="ml-4">
                        <a href="{{ route('projects.show', $project->id) }}" class="text-2xl text-gray-600 hover:underline font-semibold">{{ $project->name }}</a>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">{{ $project->description }}</p>

                @if($project->users && count($project->users) > 0)
                <div class="mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($project->users as $user)
                        <li class="text-gray-600">{{ $user->name }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="mb-4">
                    <span class="inline-block {{ $bgColor }} text-sm text-gray-600 px-2 py-1 rounded-full">{{ $project->type }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p>Henüz proje yok.</p>
        @endif
    </div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.dropdown-toggle').forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation();
            const dropdownContent = this.nextElementSibling;
            document.querySelectorAll('.dropdown-content').forEach(content => {
                if (content !== dropdownContent) {
                    content.classList.remove('show');
                }
            });
            dropdownContent.classList.toggle('show');
        });
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-content').forEach(dropdownContent => {
                dropdownContent.classList.remove('show');
            });
        }
    });
});
</script>
