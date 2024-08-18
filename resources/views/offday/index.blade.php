@extends('userLayout.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6">İzin Talepleri</h1>
        <a href="{{ route('offday.create') }}"
            class="inline-block mb-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Yeni İzin Talebi Oluştur</a>

        <div class="overflow-hidden border border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kullanıcı
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Mazeret
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Durum
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tarih
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Belge
                        </th>


                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            İşlemler
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($offdays as $offday)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $offday->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $offday->reason }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $offday->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($offday->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $offday->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $offday->offday_date }}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">

                                @if ($offday->document)
                                    <a href="{{ route('attachments.download', ['filename' => basename($offday->document)]) }}"
                                        class="text-gray-500 hover:text-gray-700 transition" title="İndir">
                                        <i class="fa-solid fa-paperclip"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400">Belge yok</span>
                                @endif


                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if (auth()->user()->isAdmin() && $offday->status === 'pending')
                                    <form action="{{ route('offdays.approve', $offday->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="text-green-600 hover:text-green-900 focus:outline-none focus:underline">Onayla</button>
                                    </form>
                                    <form action="{{ route('offdays.reject', $offday->id) }}" method="POST"
                                        class="inline-block ml-2">
                                        @csrf
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 focus:outline-none focus:underline">Reddet</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
