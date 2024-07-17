@extends('layout.app')

@section('styles')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-......" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    body {
        font-family: 'Quicksand', sans-serif;
    }
    .table-row {
        margin-bottom: 1rem; 
    }
    .table-row:hover {
        background-color: #f9fafb; 
        transition: background-color 0.3s;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-6 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl flex items-center mt-3">
            <i class="fas fa-clock mr-3 text-blue-500"></i> Kullanıcıların Mesai Bilgileri
        </h2>
        @csrf
        <form action="{{ route('admin.filterWorkSessions') }}" method="GET" class="flex items-center space-x-2">
            <select name="user_id" class="border border-gray-300 rounded-lg py-2 px-4 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">Kullanıcı Seçin</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">
                <i class="fas fa-filter mr-2"></i> Filtrele
            </button>
        </form>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-4 px-6 border-b border-gray-300 text-left">
                        <i class="fas fa-user mr-2 text-gray-600"></i> Kullanıcı
                    </th>
                    <th class="py-4 px-6 border-b border-gray-300 text-left">
                        <i class="fas fa-hourglass-start mr-2 text-gray-600"></i> Başlangıç Zamanı
                    </th>
                    <th class="py-4 px-6 border-b border-gray-300 text-left">
                        <i class="fas fa-hourglass-end mr-2 text-gray-600"></i> Bitiş Zamanı
                    </th>
                    <th class="py-4 px-6 border-b border-gray-300 text-left">
                        <i class="fas fa-info-circle mr-2 text-gray-600"></i> Durum
                    </th>
                    <th class="py-4 px-6 border-b border-gray-300 text-left">
                        <i class="fas fa-cogs mr-2 text-gray-600"></i> İşlemler
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($workSessions as $session)
                    <tr class="table-row">
                        <td class="py-4 px-6 border-b border-gray-300 flex items-center">
                            <img src="{{ asset('images/user-avatar.png') }}" alt="User Avatar" class="w-8 h-8 rounded-full mr-3">
                            <span class="text-lg font-medium">{{ $session->user->name }}</span>
                        </td>
                        <td class="py-4 px-6 border-b border-gray-300">
                            <div>{{ \Carbon\Carbon::parse($session->start_time)->format('d/m/Y') }}</div>
                            <div>{{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}</div>
                        </td>
                        <td class="py-4 px-6 border-b border-gray-300">
                            <div>{{ \Carbon\Carbon::parse($session->end_time)->format('d/m/Y') }}</div>
                            <div>{{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}</div>
                        </td>
                        <td class="py-4 px-6 border-b border-gray-300">
                            <span class="inline-block px-3 py-1 text-sm font-semibold leading-tight text-white {{ $session->status === 'completed' ? 'bg-green-500' : 'bg-red-500' }} rounded-full">
                                {{ ucfirst($session->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 border-b border-gray-300 flex items-center space-x-2">
                            <a href="{{ route('admin.editWorkSession', $session->id) }}" class="text-blue-500 hover:text-blue-800 flex items-center">
                                <i class="fas fa-edit mr-2"></i> Düzenle
                            </a>
                            <button class="text-red-500 hover:text-red-800 flex items-center">
                                <i class="fas fa-trash mr-2"></i> Sil
                            </button>
                        </td>
                    </tr>
                    @foreach($session->breaks as $break)
                        <tr class="bg-gray-50 hover:bg-gray-100 transition duration-200 mb-2">
                            <td class="py-2 px-6 border-b border-gray-300 pl-12" colspan="2">
                                <i class="fas fa-coffee mr-2 text-green-500"></i> Mola Başlangıcı: {{ \Carbon\Carbon::parse($break->start_time)->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-2 px-6 border-b border-gray-300" colspan="2">
                                <i class="fas fa-clock mr-2 text-red-500"></i> Mola Bitişi: {{ \Carbon\Carbon::parse($break->end_time)->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-2 px-6 border-b border-gray-300"></td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
