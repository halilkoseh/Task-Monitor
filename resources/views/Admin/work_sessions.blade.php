@extends('layout.app')

@section('content')
<div class="container mx-auto px-6 py-3">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Tüm Kullanıcıların Mesai Bilgileri</h2>
        <form action="{{ route('admin.filterWorkSessions') }}" method="GET" class="flex items-center">
            <select name="user_id" class="border border-gray-300 rounded py-2 px-4 mr-2">
                <option value="">Kullanıcı Seçin</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Filtrele</button>
        </form>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Kullanıcı</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Başlangıç Zamanı</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Bitiş Zamanı</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Durum</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workSessions as $session)
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-300">{{ $session->user->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{ $session->start_time }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{ $session->end_time }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{ $session->status }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">
                            <a href="{{ route('admin.editWorkSession', $session->id) }}" class="text-blue-500 hover:text-blue-800">Düzenle</a>
                        </td>
                    </tr>
                    @foreach($session->breaks as $break)
                        <tr class="bg-gray-100">
                            <td class="py-1 px-4 border-b border-gray-300 pl-10">Mola Başlangıcı: {{ $break->start_time }}</td>
                            <td class="py-1 px-4 border-b border-gray-300">Mola Bitişi: {{ $break->end_time }}</td>
                            <td class="py-1 px-4 border-b border-gray-300"></td>
                            <td class="py-1 px-4 border-b border-gray-300"></td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
