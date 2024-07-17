<!--font-family-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .sidebar-item:hover {
        background-color: #f2e4f9;
        color: #4a5568; /* text-gray-800 */
        border-radius: 9999px; /* rounded-full */
        transition: all 0.2s;
    }
    .sidebar-item {
        transition: all 0.2s;
    }

    .body {
        font-family: 'Quicksand', monospace;
    }

</style>

<!-- Sidebar -->
<div class="body">
    
<div class="w-64 bg-gray-700 h-screen p-5 text-white rounded-3xl">
        <div class="flex items-center mb-20">
            <a href="{{ asset('admin') }}" class="flex items-center">
                <img src="{{ asset('images/logo1.png') }}" alt="logo" class="w-12 mr-1" /> <!-- Logo boyutu küçültüldü -->
                <div>
                    <span class="font-quicksand text-2xl">TaskManager</span> <!-- Yazı yanına getirildi -->
                </div>
            </a>
        </div>
        <ul class="space-y-3.5">
            <li>
                <a href="{{ route('user') }}" class="sidebar-item flex items-center text-lg">
                    <i class="fas fa-th-large mr-2"></i> <!-- Icon and text spacing adjusted -->
                    Kullanıcı Paneli
                </a>
            </li>
            <li>
            <li class="space-y-3.5">
                <a href="#" class="sidebar-item flex items-center text-lg">
                    <i class="fas fa-calendar-alt mr-3"></i>
                    Takvim
                </a>
            </li> 
                <a href="{{ route('user.workSessions') }}" class="sidebar-item flex items-center text-lg">
                    <i class="fa-solid fa-clock mr-2"></i> <!-- Icon and text spacing adjusted -->
                    Mesai Giriş/Çıkış
                </a>
            </li>
            <li>
                <a href="{{ route('offday.index') }}" class="sidebar-item flex items-center text-lg">
                    <i class="fa-solid fa-copy mr-2"></i> <!-- Icon and text spacing adjusted -->
                    İzin Takip
                </a>
            </li>
                    <li class="mb-4">
                        <a href="{{ route('userProfile') }}" class="sidebar-item flex items-center text-lg">
                        <i class="fas fa-user mr-3"></i>Profilim</a>
                </li>
            
            </ul>
     
       



   

<!--
            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute left-0 mt-2 w-48 bg-white border rounded-md shadow-lg">
                <a href="{{ route('userProfile') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profili
                    Görüntüle</a>
                    <form action="{{ route('logout') }}" method="POST" class="flex items-center gap-4 pl-2">
                @csrf
                <button type="submit" class="text-white hover:text-blue-800 transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-sign-out-alt text-md mb-1"></i> 
                    <span class="text-md mb-1">Çıkış Yap</span>
                </button>
            </form>
            </div>
-->
<div class="flex flex-col justify-center mt-60 gap-1 border-t border-white pt-2">
            <a href="{{ route('profile') }}" class="text-white hover:text-blue-800 transition-colors duration-200 flex items-center gap-2 pl-2">
                <i class="fas fa-cog text-md"></i> 
                <span class="text-md">Ayarlar</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="flex items-center gap-4 pl-2">
                @csrf
                <button type="submit" class="text-white hover:text-blue-800 transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-sign-out-alt text-md mb-1"></i> <!-- İkon boyutu büyütüldü -->
                    <span class="text-md mb-1">Çıkış Yap</span>
                </button>
            </form>

        </div>
    </div>
</div>
