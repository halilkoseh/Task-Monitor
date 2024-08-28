@extends('userLayout.app')

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

        .body {
            font-family: 'Nunito', sans-serif;
            background-color: #EEF6FF;
        }
    </style>





    <div class="container mx-auto px-6 py-3 ml-96 mr-8 bg-[#EEF6FF]">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-3xl flex items-center mt-2">
                <i class="fas fa-clock mr-3 text-sky-500"></i> Mesai Takibim
            </h2>

        </div>




        <div class="mb-6 bg-[#EEF6FF] flex justify-between items-center">
            <form action="{{ route('user.startWorkSession') }}" method="POST" class="inline-block mt-4">
                @csrf
                <div>
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-green-500 text-white rounded-full shadow-lg hover:bg-green-600 transition duration-200 transform hover:scale-105">
                        <i class="fa-solid fa-briefcase text-xl"></i> Mesaimi Başlat
                    </button>
            </form>
        </div>
        <div>



            <form action="{{ route('user.startBreak') }}" method="POST" class="inline-block mt-4">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-yellow-500 text-white rounded-full shadow-lg hover:bg-yellow-600 transition duration-200 transform hover:scale-105">
                    <i class="fa-solid fa-mug-hot text-xl"></i> Molamı Başlat
                </button>
            </form>
        </div>
        <div>
            <form action="{{ route('user.endBreak') }}" method="POST" class="inline-block mt-4">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-red-500 text-white rounded-full shadow-lg hover:bg-red-600 transition duration-200 transform hover:scale-105">
                    <i class="fa-solid fa-mug-saucer text-xl"></i> Molamı Bitir
                </button>
            </form>
        </div>

        <div>
            <form action="{{ route('user.endWorkSession') }}" method="POST" class="inline-block mt-4">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transition duration-200 transform hover:scale-105">
                    <i class="fa-solid fa-umbrella-beach text-xl"></i> Mesaimi Bitir
                </button>
            </form>
        </div>

        @if ($formattedTotalWorkDuration)
            <div class="bg-[#535353] text-white rounded-full px-4 py-2 mt-4 hover:bg-[#7F7F7F] hover:scale-105">

                <div class="flex items-center justify-end space-x-2 ">
                    <p class="text-lg "><i class="fa-solid fa-stopwatch mr-2"></i> Toplam Süre:</p>
                    <p class="text-lg font-semibold">{{ $formattedTotalWorkDuration }}</p>
                </div>
            </div>
        @endif

    </div>

    <div class="space-y-6"> <!-- Added this div to space out the cards -->
        @foreach ($workSessions as $session)
            <div class="bg-gradient-to-r from-[#EEF6FF] to-blue-100 shadow-lg rounded-xl overflow-hidden p-4">
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <table class="min-w-full bg-white">
                        <thead class="bg-[#7F7F7F] text-white">
                            <tr>
                                <th class="py-3 px-6 text-left font-semibold">Başlangıç Zamanı</th>
                                <th class="py-3 px-6 text-left font-semibold">Bitiş Zamanı</th>
                                <th class="py-3 px-6 text-left font-semibold">Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-blue-50 transition-colors duration-200">
                                <td class="py-3 px-6 border-b border-gray-300">{{ $session->start_time }}</td>
                                <td class="py-3 px-6 border-b border-gray-300">{{ $session->end_time }}</td>
                                <td class="py-3 px-6 border-b border-gray-300">
                                    @php
                                        $statusColors = [
                                            'working' => 'bg-green-500 text-[#fff]',
                                            'on_break' => 'bg-yellow-500 text-[#fff]',
                                            'ended' => 'bg-blue-500 text-[#fff]',
                                        ];
                                    @endphp
                                    <span
                                        class="px-2 py-1 rounded-full text-sm font-medium {{ $statusColors[$session->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $session->status }}
                                    </span>
                                </td>
                            </tr>
                            @foreach ($session->breaks as $break)
                                <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <td class="py-2 px-6 border-b border-gray-300 pl-12">Mola Başlangıcı: {{ $break->start_time }}</td>
                                    <td class="py-2 px-6 border-b border-gray-300">Mola Bitişi: {{ $break->end_time }}</td>
                                    <td class="py-2 px-6 border-b border-gray-300"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
    

    </div>
@endsection
