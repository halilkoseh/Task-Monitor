@extends('layout.app')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    integrity="sha512-......" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    body {
        font-family: 'Quicksand', sans-serif;
    }

    .main-content {
        min-height: 100vh;
        margin-left: 24rem;
        padding: 1rem;
        box-sizing: border-box;
        padding: 20px;
        box-sizing: border-box;
    }

    .table-row {
        margin-bottom: 1rem;
    }

    .table-row:hover {
        background-color: #f9fafb;
        transition: background-color 0.3s;
    }

    .dropdown {
        position: relative;
    }

    .dropdown-toggle {
        background: none;
        border: none;
        cursor: pointer;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        z-index: 10;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.25rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .dropdown-content a,
    .dropdown-content form {
        display: block;
        padding: 0.5rem 1rem;
        text-decoration: none;
        color: #212529;
    }

    .dropdown-content a:hover,
    .dropdown-content form:hover {
        background-color: #f8f9fa;
    }

    .dropdown-content.show {
        display: block;
    }
</style>

@section('content')
    <div class="main-content">
        <div class="container mx-auto p-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl flex items-center mt-2">
                    <i class="fas fa-clock mr-3 text-sky-500"></i> Kullanıcıların Mesai Bilgileri
                </h2>
                @csrf
                <form action="{{ route('admin.filterWorkSessions') }}" method="GET" class="flex items-center space-x-2">
                    <select name="user_id"
                        class="border border-gray-300 rounded-lg py-2 px-4 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        <option value="">Kullanıcı Seçin</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="flex items-center px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-blue-500 transition duration-200">
                        <i class="fas fa-filter mr-2"></i> Filtrele
                    </button>
                </form>
            </div>

            <div class="bg-white shadow-lg rounded-3xl overflow-hidden">
                <table class="min-w-full bg-white border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-4 px-6 border-b border-gray-300 text-left">
                                <div class="flex items-center">
                                    <i class="fas fa-user mr-2 text-gray-600"></i>
                                    <div>Kullanıcı</div>
                                </div>
                            </th>
                            <th class="py-4 px-6 border-b border-gray-300 text-left">
                                <div class="flex items-center">
                                    <i class="fas fa-hourglass-start mr-2 text-gray-600"></i>
                                    <div>Mesai Başlangıcı</div>
                                </div>
                            </th>
                            <th class="py-4 px-6 border-b border-gray-300 text-left">
                                <div class="flex items-center">
                                    <i class="fas fa-hourglass-end mr-2 text-gray-600"></i>
                                    <div>Mesai Bitişi</div>
                                </div>
                            </th>
                            <th class="py-4 px-6 border-b border-gray-300 text-left">
                                <div class="flex items-center">
                                    <i class="fas fa-info-circle mr-2 text-gray-600"></i>
                                    <div>Durum</div>
                                </div>
                            </th>
                            <th class="py-4 px-6 border-b border-gray-300 text-left">
                                <div class="flex items-center">
                                    <i class="fas fa-coffee mr-2 text-gray-600"></i>
                                    <div>Mola Başlangıcı</div>
                                </div>
                            </th>
                            <th class="py-4 px-6 border-b border-gray-300 text-left">
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-2 text-gray-600"></i>
                                    <div>Mola Bitişi</div>
                                </div>
                            </th>
                            <th class="py-4 px-6 border-b border-gray-300 text-left">
                                <div class="flex items-center">
                                    <i class="fas fa-cogs mr-2 text-gray-600"></i>
                                    <div>İşlemler</div>
                                </div>
                            </th>
                        </tr>
                    </thead>


                    @foreach ($workSessions as $session)
                        <tr class="table-row bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="py-6 px-8 border-b border-gray-300 flex items-center space-x-6">
                                <img src="{{ asset('images/' . $user->profilePic) }}" alt="{{ $user->name }}"
                                    class="w-12 h-12 rounded-full object-cover border-2 border-gray-300 shadow-lg">
                                <span class="text-lg font-semibold text-gray-800">{{ $session->user->name }}</span>
                            </td>

                            <td class="py-6 px-8 border-b border-gray-300">
                                <p class="text-sm text-gray-600">{{ $session->created_at }}</p>
                            </td>

                            <td class="py-6 px-8 border-b border-gray-300">
                                <p class="text-sm text-gray-600">{{ $session->end_time }}</p>
                            </td>

                            <td class="py-6 px-8 border-b border-gray-300">
                                @php
                                    $badgeColor =
                                        $session->status === 'completed'
                                            ? 'bg-green-500 text-white'
                                            : ($session->status === 'working'
                                                ? 'bg-purple-100 text-gray-600'
                                                : 'bg-orange-100 text-gray-600');
                                @endphp
                                <span
                                    class="inline-block px-4 py-2 text-sm font-semibold leading-tight rounded-full {{ $badgeColor }}">
                                    {{ ucfirst($session->translated_status) }}
                                </span>
                            </td>

                            <td class="py-6 px-8 border-b border-gray-300">
                                @foreach ($session->breaks as $break)
                                    <p class="py-2 pl-16 text-gray-600 text-sm">
                                        {{ $break->created_at }}
                                    </p>
                                @endforeach
                            </td>

                            <td class="py-6 px-8 border-b border-gray-300">
                                @foreach ($session->breaks as $break)
                                    <span
                                        class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($break->end_time)->format('d/m/Y H:i') }}</span>
                                @endforeach
                            </td>

                            <td class="py-6 px-8 border-b border-gray-300 relative">
                                <div class="dropdown flex justify-center text-red-600">
                                    <button class="dropdown-toggle">
                                        <i class="fa-solid fa-file-pen"></i>
                                    </button>
                                    <div class="dropdown-content bg-white shadow-lg rounded-lg p-2">
                                        <a href="{{ route('admin.editWorkSession', $session->id) }}"
                                            class="block px-4 py-2 text-blue-600 hover:bg-blue-100 rounded">Düzenle</a>
                                        <form action="{{ route('admin.destroyWorkSession', $session->id) }}" method="POST"
                                            onsubmit="return confirm('Bu oturumu silmek istediğinize emin misiniz?');"
                                            class="block mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 rounded">
                                                Sil
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.dropdown-toggle').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.stopPropagation();
                    const dropdownContent = this.nextElementSibling;
                    document.querySelectorAll('.dropdown-content').forEach(content => {
                        if (content !== dropdownContent) {
                            content.classList.remove('show');
                        }
                    });
                    dropdownContent.classList.toggle('show');
                });
            });

            document.addEventListener('click', function(event) {
                if (!event.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown-content').forEach(dropdownContent => {
                        dropdownContent.classList.remove('show');
                    });
                }
            });
        });
    </script>
@endsection
