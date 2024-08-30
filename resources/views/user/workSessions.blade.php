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

        <div>
            <div
                class="bg-[#7F7F7F] text-white rounded-full px-4 py-2 mt-4 hover:bg-white hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-end space-x-2">

                    @if ($workSessions->isNotEmpty())
                        <p class="bg-[#7F7F7F] rounded-lg px-3 py-1">Mesai Durumu: {{ $workSessions->last()->status }}</p>
                    @else
                        <p class="bg-[#7F7F7F] rounded-lg px-3 py-1">Mesai Durumu: Başlamadı</p>
                    @endif
                </div>
            </div>
        </div>


        <div>
            @if ($formattedWorkDurations)
                <div class="bg-[#535353] text-white rounded-full px-4 py-2 mt-4 hover:bg-[#7F7F7F] hover:scale-105">
                    <div class="flex items-center justify-end space-x-2 ">
                        <p class="text-lg"> Mevcut Oturum:</p>
                        <p class="text-lg font-semibold">{{ end($formattedWorkDurations) }}</p>
                    </div>
                </div>
            @endif
        </div>



    </div>
    @php
$workSessions = $workSessions->sortByDesc('created_at');
    @endphp
    <div class="space-y-8"> 
        @foreach ($workSessions as $session)
            <div class="bg-[] shadow-xl rounded-lg overflow-hidden p-6">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-[#7F7F7F] text-white py-2 px-4">
                        <p class="text-lg font-semibold">
                            Tarih: {{ \Carbon\Carbon::parse($session->created_at)->format('d.m.Y') }}
                        </p>

                    </div>
                    <table class="min-w-full bg-white mt-4">
                        <thead class="bg-[#555555] text-white">
                            <tr>
                                <th class="py-3 px-6 text-left font-semibold">Başlangıç Zamanı</th>
                                <th class="py-3 px-6 text-left font-semibold">Bitiş Zamanı</th>
                                <th class="py-3 px-6 text-left font-semibold">Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-[#E0F2FE] transition-colors duration-200">
                                <td class="py-3 px-6 border-b border-gray-300">{{ $session->created_at }}</td>
                                <td class="py-3 px-6 border-b border-gray-300">{{ $session->end_time }}</td>
                                <td class="py-3 px-6 border-b border-gray-300">
                                    @php
                                        $statusColors = [
                                            'working' => 'bg-green-500 text-white',
                                            'on_break' => 'bg-yellow-500 text-white',
                                            'ended' => 'bg-blue-500 text-white',
                                        ];
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$session->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($session->status) }}
                                    </span>
                                </td>
                            </tr>
                            @foreach ($session->breaks as $break)
                                <tr class="bg-[#F9FAFB] hover:bg-[#F3F4F6] transition-colors duration-200">
                                    <td class="py-2 px-6 border-b border-gray-300 pl-12">
                                        <span class="font-semibold">Mola Başlangıcı:</span>
                                        {{ \Carbon\Carbon::parse($break->created_at)->format('H:i:s') }}
                                    </td>
                                    <td class="py-2 px-6 border-b border-gray-300">
                                        <span class="font-semibold">Mola Bitişi:</span>
                                        {{ \Carbon\Carbon::parse($break->end_time)->format('H:i:s') }}
                                    </td>
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
