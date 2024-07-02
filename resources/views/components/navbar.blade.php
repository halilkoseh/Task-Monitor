<div class="bg-white w-64 min-h-screen shadow-lg flex flex-col">
    <!-- Logo and Title -->
    <div class="p-6 flex items-center gap-2 border-b">
        <span class="text-xl font-bold text-gray-800">Task Monitor</span>
    </div>

    <!-- Navigation Links -->
    <div class="flex flex-col mt-4 space-y-2 flex-grow">
        <a href="{{ route('admin') }}"
            class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
            <i class="fas fa-th-large"></i> Ana Sayfa
        </a>
        <a href="#"
            class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
            <i class="fas fa-calendar-alt"></i> Takvim
        </a>
        <a href="{{ route('admin.users.create') }}"
            class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
            <i class="fa-solid fa-user-plus"></i> Kullanıcı Ekle
        </a>
        <a href="{{ route('admin.users.show') }}"
            class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
            <i class="fa-solid fa-users"></i> Kullanıcılar
        </a>
        <a href="{{ route('admin.users.assaign') }}"
            class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
            <i class="fa-solid fa-list-check"></i> Görev Ata
        </a>





        <a href="{{ route('projects.index') }}"
            class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
            <i class="fa-solid fa-microchip"></i> Projeler
        </a>



        <a href=""
            class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
            <i class="fa-solid fa-file-pen"></i> Raporlar
        </a>

        <a href=""
            class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
            <i class="fa-solid fa-clock"></i> Mesai Takip
        </a>

    </div>


    <!-- User Profile Section at the Bottom -->
    <div class="p-4 bg-gray-100 mt-auto flex items-center gap-2 border-t">
        <div>
            <div class="text-gray-800">{{ Auth::user()->name }}</div>
            <div class="text-xs text-gray-500">{{ Auth::user()->gorev }}</div>
        </div>
        <a href="{{ route('profile') }}"
            class="ml-auto text-gray-500 hover:text-gray-800 transition-colors duration-200">
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
