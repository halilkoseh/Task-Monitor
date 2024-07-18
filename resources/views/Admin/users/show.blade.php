@extends('layout.app')

@section('content')
    <div class="main-content w-5/6 p-5 mt-2">
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-3xl font-semibold">
                <i class="fas fa-users mr-3 text-blue-500"></i> Kullanıcı Listesi
            </h2>
            <a href="{{ route('admin.users.create') }}"
                class="bg-blue-500 text-white px-6 py-3 rounded-full hover:bg-blue-600 transform hover:scale-110 transition duration-300">
                <span class="text-lg font-semibold"><i class="fa-solid fa-circle-plus"></i> Kullanıcı Ekle</span>
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('admin.users.search1') }}" method="GET" class="mb-5">
            <div class="flex items-center">
                <input type="text" name="search" value="{{ request()->query('search') }}"
                    class="border rounded-lg px-4 py-2 w-full" placeholder="Kullanıcı adı ile ara...">
                <button type="submit"
                    class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                    <i class="fa-solid fa-magnifying-glass"></i>

                </button>
            </div>
        </form>

        @if ($users->isEmpty())
            <p class="text-gray-500">Hiç kullanıcı bulunamadı.</p>
        @else
           
        
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($users as $user)
                    <div
                        class="border rounded-md overflow-hidden shadow-lg {{ ['bg-white', 'bg-white', 'bg-white', 'bg-white'][$loop->index % 4] }}">
                        <div class="p-4">
                            <div class="flex items-center mb-4">





                                <img src="{{ asset('storage/profile_pics/' . $user->profilePic) }}"
                                    alt="{{ $user->name }}" class="w-12 h-12 rounded-full object-cover mr-3">





                                <div>
                                    <h3 class="text-lg font-semibold">{{ $user->name }}</h3>
                                    <p class="text-gray-600">{{ $user->gorev }}</p>
                                </div>
                            </div>
                            <p><strong>Kullanıcı Adı:</strong> {{ $user->username }}</p>
                            <p><strong>E-posta:</strong> {{ $user->email }}</p>
                            <p><strong>Telefon:</strong> {{ $user->phoneNumber }}</p>
                            <p><strong>LinkedIn:</strong> {{ $user->linkedinAddress }}</p>
                            <p><strong>Portföy:</strong> {{ $user->portfolioLink }}</p>
                            <div class="mt-4 flex justify-end space-x-2">

                                
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300">Sil</button>
                                </form>
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">Düzenle</a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
