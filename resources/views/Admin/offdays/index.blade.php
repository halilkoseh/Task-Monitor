@extends('layout.app')

@section('content')
    <div class="py-6">
        <h1 class="text-2xl font-bold mb-6">İzin Talepleri</h1>
        
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Kullanıcı</th>
                        <th class="px-4 py-2 text-left">Mazeret</th>
                        <th class="px-4 py-2 text-left">Durum</th>
                        <th class="px-4 py-2 text-left">Belge</th>
                        <th class="px-4 py-2 text-left">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offdays as $offday)
                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                        <td class="border px-4 py-2">{{ $offday->user->name }}</td>
                        <td class="border px-4 py-2">{{ $offday->reason }}</td>
                        <td class="border px-4 py-2">{{ $offday->status }}</td>
                        <td class="border px-4 py-2">
                            @if ($offday->document)
                                <a href="{{ asset('storage/' . $offday->document) }}" target="_blank" class="text-blue-600 hover:underline">Belgeyi Görüntüle</a>
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            @if ($offday->status == 'pending')
                                <form action="{{ route('offdays.approve', $offday->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:underline">Onayla</button>
                                </form>
                                <form action="{{ route('offdays.reject', $offday->id) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:underline">Reddet</button>
                                </form>
                            @else
                                <span class="text-gray-600">{{ ucfirst($offday->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
