@extends('layout.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Oturumu Sil</h2>
    <form action="{{ route('admin.deleteWorkSession', $workSession->id) }}" method="POST" onsubmit="return confirm('Bu oturumu silmek istediğinize emin misiniz?');">
        @csrf
        @method('DELETE')

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Başlangıç Zamanı</label>
            <input type="text" value="{{ \Carbon\Carbon::parse($workSession->start_time)->format('d/m/Y H:i') }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100" disabled>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Bitiş Zamanı</label>
            <input type="text" value="{{ \Carbon\Carbon::parse($workSession->end_time)->format('d/m/Y H:i') }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100" disabled>
        </div>

        <div class="text-center">
            <button type="submit" class="px-6 py-3 text-white bg-red-500 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">Sil</button>
            <a href="{{ route('admin.workSessions') }}" class="px-6 py-3 text-white bg-gray-500 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">İptal</a>
        </div>
    </form>
</div>
@endsection
