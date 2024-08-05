<style>
    .content-container {
        min-height: 100vh;
        margin-left: 18rem;
        padding: 20px;
        box-sizing: border-box;
    }

    .card {
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>
@extends('layout.app')

@section('content')
    <div class="content-container py-8 px-6">

        <h1 class="text-3xl text-gray-600 mb-6"><i class="fa-regular fa-pen-to-square text-sky-500"></i> İzin Talepleri</h1>

        <div class="cards-container mx-auto max-w-4xl">
            @foreach ($offdays as $offday)
                <div x-data="{ isOpen: false, isDropdownOpen: false }" class="card">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-gray-700"><strong>Adı-Soyadı: </strong> {{ $offday->user->name }}</div>




                        <div class="relative">
                            <button @click="isDropdownOpen = !isDropdownOpen" class="text-gray-600 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v.01M12 12v.01M12 18v.01"></path>
                                </svg>
                            </button>

                            <div x-show="isDropdownOpen" @click.away="isDropdownOpen = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                                <a href="{{ route('admin.offdays.edit', $offday->id) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Düzenle</a>
                                <form action="{{ route('admin.offdays.destroy', $offday->id) }}" method="POST"
                                    class="block w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sil</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 text-gray-600"><strong>Mazeret:</strong> {{ $offday->reason }}</div>
                    <div class="text-gray-700"><strong>İzin Tarihi: </strong> {{ $offday->offday_date}}</div>

                    <div class="mb-2">
                        <strong> Onayla / Reddet : </strong>
                        <span @click="isOpen = !isOpen"
                            :class="{ 'text-green-600': '{{ $offday->status }}'
                                === 'approved', 'text-red-600': '{{ $offday->status }}'
                                === 'rejected', 'text-gray-600': '{{ $offday->status }}'
                                === 'pending' }"
                            class="badge cursor-pointer hover:underline">
                            {{ ucfirst($offday->status) }}
                        </span>
                    </div>

                    <div class="mb-2">
                        @if ($offday->document)
                            <a href="{{ asset('storage/' . $offday->document) }}" target="_blank"
                                class="text-sky-500 hover:underline">Belgeyi Görüntüle</a>
                        @else
                            <span class="text-gray-400">Belge yok</span>
                        @endif
                    </div>

                    <div x-show="isOpen">
                        @if ($offday->status == 'pending')
                            <form action="{{ route('admin.offdays.approve', $offday->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 hover:underline">Onayla</button>
                            </form>

                            <form action="{{ route('admin.offdays.reject', $offday->id) }}" method="POST"
                                class="inline-block ml-2">
                                @csrf
                                <button type="submit" class="text-red-600 hover:underline">Reddet</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
