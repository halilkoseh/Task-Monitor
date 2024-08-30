<style>
    .content-container {
        min-height: 100vh;
        margin-left: 40rem;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        box-sizing: border-box;
    }
</style>

@extends('layout.app')

@section('content')
    <div class="content-container bg-gray-100">
        <div class="max-w-4xl w-full bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center mb-6">
                <a href="{{ route('admin.offdays.index') }}" class="text-sky-500 hover:underline flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Geri Dön
                </a>
            </div>
            <h1 class="text-3xl font-bold text-center mb-6">İzin Talebini Düzenle</h1>

            <form action="{{ route('admin.offdays.update', $offday->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700">Mazeret</label>
                    <input type="text" name="reason" id="reason" value="{{ $offday->reason }}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="offday_date" class="block text-sm font-medium text-gray-700">İzin Günü</label>
                    <input type="date" name="offday_date" id="offday_date" value="{{ $offday->offday_date }}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">




                    <div>
                        <label for="document" class="block text-sm font-medium text-gray-700">Belge</label>
                        <input type="file" name="document" id="document"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @if ($offday->document)
                            <p class="mt-2 text-sm text-gray-500">Mevcut Belge: <a
                                    href="{{ asset('storage/' . $offday->document) }}" target="_blank"
                                    class="text-sky-500 hover:underline">Belgeyi Görüntüle</a></p>
                        @endif
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="ml-2 bg-sky-600 text-white px-4 py-2 rounded-full shadow-sm hover:bg-indigo-700">Güncelle</button>
                    </div>
            </form>
        </div>
    </div>
@endsection
