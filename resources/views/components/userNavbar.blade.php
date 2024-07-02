<div class="bg-white w-64 min-h-screen shadow-lg flex flex-col">
    <div class="p-6 bg-blue-800 text-white text-xl font-bold">
        <a href="{{ route('user') }}" class="flex items-center gap-2">
            <i class="fas fa-tachometer-alt"></i> Task Manager
        </a>
    </div>
    <div class="flex flex-col mt-4 space-y-2">
        <a href="{{ route('user') }}" class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-100 hover:text-blue-800">
            <i class="fas fa-home"></i> Anasayfa
        </a>

        <div class="relative group" x-data="{ open: false }">
            <a href="#" class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-100 hover:text-blue-800" @click="open = !open">
                <i class="fas fa-user"></i> Profilim
            </a>
            <div x-show="open" @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute left-0 mt-2 w-48 bg-white border rounded-md shadow-lg">
                <a href="{{route('userProfile')}}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profili Görüntüle</a>
                <form action="{{ route('logout') }}" method="POST" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                    @csrf
                    <button type="submit" class="w-full text-left">Çıkış Yap</button>
                </form>            </div>
        </div> 
    </div>
    <a href="{{ route('user') }}" class="flex items-center gap-2 px-6 py-3 text-gray-800 hover:bg-blue-100 hover:text-blue-800">
            <i class="fas fa-clock"></i> Mesai Takip
    </a>
</div>
