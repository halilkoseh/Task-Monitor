

@extends('layout.app')

@section('content')


<div class="flex-1 p-6 mt-8">
    <h1 class="text-3xl font-semibold mb-6 text-center">Kullanıcılar Tablosu</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-6 py-3 border-b border-gray-300 text-left text-xs leading-4 font-medium uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 border-b border-gray-300 text-left text-xs leading-4 font-medium uppercase tracking-wider">Adı Soyadı</th>
                    <th class="px-6 py-3 border-b border-gray-300 text-left text-xs leading-4 font-medium uppercase tracking-wider">Kullanıcı Adı</th>
                    <th class="px-6 py-3 border-b border-gray-300 text-left text-xs leading-4 font-medium uppercase tracking-wider">Görevi</th>
                    <th class="px-6 py-3 border-b border-gray-300 text-left text-xs leading-4 font-medium uppercase tracking-wider">İşlemler</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($users as $user)
                <tr class="hover:bg-gray-100 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">{{ $user->id }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">{{ $user->username }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">{{ $user->gorev }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-800">Düzenle</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection
