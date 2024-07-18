<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .sidebar-item {
        transition: all 0.2s;
    }
</style>

<!-- Sidebar -->
<div class="flex">
    <div class="w-full bg-gray-700 h-full p-5 text-white ">
        <div class="flex items-center mb-20">
            <a href="{{ asset('admin') }}" class="flex items-center">
                <img src="{{ asset('images/logo1.png') }}" alt="logo" class="w-12 mr-1" />
                <div>
                    <span class="font-quicksand text-2xl">TaskManager</span>
                </div>
            </a>
        </div>

        <ul class="space-y-8 ">
            <li>
                <a href="{{ route('admin') }}" class="sidebar-item flex items-center text-lg hover:text-black">
                    <i class="fas fa-th-large mr-3 hover:text-black"></i>
                    Admin Paneli
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.show') }}" class="sidebar-item flex items-center text-lg">
                    <i class="fa-solid fa-users mr-2"></i>
                    Kullanıcılar
                </a>
            </li>
            <!-- <li>
                <a href="{{ route('admin.users.assaign') }}" class="sidebar-item flex items-center text-lg">
                    <i class="fa-solid fa-list-check mr-3"></i>
                    Görev Ata
                </a>
            </li>-->
            <li>
                <a href="{{ route('tasks.index') }}" class="sidebar-item flex items-center text-lg">
                    <i class="fa-solid fa-file mr-4"></i>
                    Görev Düzenle
                </a>
            </li>
            <li>
                <a href="{{ route('admin.workSessions') }}" class="sidebar-item flex items-center text-lg">
                    <i class="fa-solid fa-clock mr-3"></i>
                    Mesai Takip
                </a>
            </li>
            <li>
                <a href="{{ route('projects.index') }}" class="sidebar-item flex items-center text-lg">
                    <i class="fa-solid fa-file-code mr-4"></i>
                    Projeler
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-item flex items-center text-lg">
                    <i class="fa-solid fa-copy mr-3"></i>
                    Raporlar
                </a>
            </li>
            <li>
                <a href="{{ route('offdays.index') }}" class="sidebar-item flex items-center text-lg">
                    <i class="fa-solid fa-copy mr-3"></i>
                    İzin Takip
                </a>
            </li>
        </ul>


        <div class="flex flex-col justify-center mt-40 gap-1 border-t border-white pt-2">
            <a href="{{ route('profile') }}"
                class="text-white hover:text-blue-800 transition-colors duration-200 flex items-center gap-2 pl-2">
                <i class="fas fa-cog text-md mr-1"></i>
                <span class="text-md">Ayarlar</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="flex items-center gap-4 pl-2">
                @csrf
                <button type="submit"
                    class="text-white hover:text-blue-800 transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-sign-out-alt text-md mb-1 mr-1"></i>
                    <span class="text-md mb-1">Çıkış Yap</span>
                </button>
            </form>
        </div>
    </div>
</div>
