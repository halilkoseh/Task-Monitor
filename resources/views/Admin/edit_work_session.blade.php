@extends('layout.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Çalışma Oturumunu Güncelle</h2>
    <form action="{{ route('admin.updateWorkSession', $workSession->id) }}" method="POST">
        @csrf
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Başlangıç Zamanı</label>
            <input type="datetime-local" name="start_time" value="{{ optional($workSession->start_time)->format('Y-m-d\TH:i') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Mola Başlangıç Zamanları</label>
            @foreach($workSession->breaks as $break)
                <div class="mb-4">
                    <input type="datetime-local" name="breaks[{{ $break->id }}][start_time]" value="{{ optional($break->start_time)->format('Y-m-d\TH:i') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2">
                    <label class="block text-gray-700 font-semibold mb-2">Mola Bitiş Zamanı</label>
                    <input type="datetime-local" name="breaks[{{ $break->id }}][end_time]" value="{{ optional($break->end_time)->format('Y-m-d\TH:i') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2">
                </div>
            @endforeach
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Bitiş Zamanı</label>
            <input type="datetime-local" name="end_time" value="{{ optional($workSession->end_time)->format('Y-m-d\TH:i') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
f
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Durum</label>
            <select name="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="started" {{ $workSession->status === 'started' ? 'selected' : '' }}>Başlatıldı</option>
                <option value="on_break" {{ $workSession->status === 'on_break' ? 'selected' : '' }}>Mola</option>
                <option value="ended" {{ $workSession->status === 'ended' ? 'selected' : '' }}>Bitti</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="px-6 py-3 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Güncelle</button>
        </div>
    </form>
</div>
@endsection
