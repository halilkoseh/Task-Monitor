@extends('layout.app')

@section('content')
    <div class="container mx-auto mt-32 p-4 md:flex md:space-x-8">
        <div
            class="shadow-lg rounded-xl p-8 mb-6 md:mb-0 transition-transform transform hover:scale-105 duration-300 flex-1 md:ml-64 bg-white border border-gray-200">
            <div class="mb-8">
                @if (auth()->user()->is_admin)
                    <a href="{{ route('admin.contacts.index') }}"
                        class="text-sky-600 hover:text-blue-800 transition-colors duration-200 flex items-center">
                        <i class="fa-solid fa-chevron-left mr-2"></i> Geri Dön
                    </a>
                @else
                    <a href="{{ route('mission.indexUser') }}"
                        class="text-sky-600 hover:text-blue-800 transition-colors duration-200 flex items-center">
                        <i class="fa-solid fa-chevron-left mr-2"></i> Geri Dön
                    </a>
                @endif
            </div>
            <div class="space-y-6">
                <h1 class="text-4xl font-extrabold mb-6 text-gray-800 flex justify-center items-center">
                    <i class="fa-solid fa-headset mr-4 text-blue-600"></i> Destek Talebi  #{{ $contacts->id }}
                </h1>

                @php
                    $user = $contacts->user;
                @endphp

                <p><strong>Ad Soyad:</strong> {{ $user->name }}</p>
                <p><strong>Telefon:</strong> {{ $user->username }}</p>
                <p><strong>Görev:</strong> {{ $user->gorev }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Konu:</strong> {{ $contacts->name }}</p>
                <p><strong>Başlık:</strong> {{ $contacts->email }}</p>
                <p><strong>Mesaj:</strong> {{ $contacts->message }}</p>
                <p><strong>Gönderim Tarihi:</strong> {{ $contacts->created_at->format('d-m-Y H:i') }}</p>

                @if (auth()->user()->is_admin)
                    <div class="mt-8 flex justify-between">
                        <a href="mailto:{{ $user->email }}?subject={{ urlencode($contacts->email) }}"
                            class="bg-blue-600 hover:bg-blue-800 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-200"
                            aria-label="Email {{ $user->name }}">
                            Yanıtla
                        </a>





                        <form action="{{ route('contact.destroy', $contacts->id) }}" method="POST"
                            onsubmit="return confirm('Bu destek talebini silmek istediğinize emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-800 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-200">
                                Sil
                            </button>
                        </form>


                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
