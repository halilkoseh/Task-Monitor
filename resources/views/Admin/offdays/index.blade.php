@extends('layout.app')

@section('content')
    <style>
        .main-content {
            min-height: 100vh;
            margin-left: 18rem;
            margin-right: 2rem;
            padding: 20px;
            box-sizing: border-box;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            z-index: 1000;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.25rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            white-space: nowrap;
            overflow: visible;
        }

        .dropdown-content.show {
            display: block;
        }

        .table-container {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 0.5rem;
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .table-container th,
        .table-container td {
            padding: 0.75rem;
            text-align: left;
            white-space: nowrap;
        }

        .table-container th {
            background-color: #e9ecef;
            font-weight: 600;
        }

        .table-container td {
            border-bottom: 1px solid #dee2e6;
        }

        .table-container tr {
            background-color: #ffffff;
            transition: background-color 0.2s;
        }

        .table-container tr:hover {
            background-color: #f1f3f5;
        }

        .table-container tr:first-child th:first-child,
        .table-container tr:first-child td:first-child {
            border-top-left-radius: 0.75rem;
        }

        .table-container tr:first-child th:last-child,
        .table-container tr:first-child td:last-child {
            border-top-right-radius: 0.75rem;
        }

        .table-container tr:last-child th:first-child,
        .table-container tr:last-child td:first-child {
            border-bottom-left-radius: 0.75rem;
        }

        .table-container tr:last-child th:last-child,
        .table-container tr:last-child td:last-child {
            border-bottom-right-radius: 0.75rem;
        }

        .icon-container {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            padding: 0.5rem;
            border-radius: 0.50rem;
        }

        .icon-container img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
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
            z-index: 1000;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.25rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            white-space: nowrap;
            overflow: visible;
        }

        .dropdown-content.show {
            display: block;
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

        .text-muted {
            color: #6c757d !important;
        }

        .text-sky-500 {
            color: #0ea5e9 !important;
        }
    </style>

    <div class="main-content w-5/6 mx-auto p-4 ml-16">
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-3xl text-gray-600">
                <i class="fa-regular fa-pen-to-square text-sky-500"></i> İzin Talepleri
            </h2>
        </div>

        <div class="flex justify-between items-center mb-5">



            <form action="{{ route('admin.users.search2') }}" method="GET" class="flex items-center space-x-4">
                <input type="text" name="search" value="{{ request()->query('search') }}"
                    class="border rounded-lg px-4 py-2 w-80" placeholder="Kullanıcı adı ile ara...">

            </form>



            <form action="{{ route('admin.users.search3') }}" method="GET" class="flex items-center space-x-4">
                <!-- Durum seçici -->
                <select name="status" class="border rounded-lg px-4 py-2">
                    <option value="" disabled {{ request()->query('status') ? '' : 'selected' }}>Durum seçin</option>
                    <option value="approved" {{ request()->query('status') === 'approved' ? 'selected' : '' }}>Onaylı
                    </option>
                    <option value="pending" {{ request()->query('status') === 'pending' ? 'selected' : '' }}>Beklemede
                    </option>
                    <option value="rejected" {{ request()->query('status') === 'rejected' ? 'selected' : '' }}>Reddedildi
                    </option>
                </select>

                <input type="date" name="offday_date" value="{{ request()->query('offday_date') }}"
                    class="border rounded-lg px-4 py-2">

                <button type="submit"
                    class="ml-2 bg-sky-500 text-white px-4 py-2 rounded-lg hover:bg-sky-600 transition duration-300">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>











            <div class="flex items-center ml-4">
                <p class="text-gray-600 underline">{{ $offdays->count() }} talep listeleniyor..</p>
            </div>
        </div>


        <div class="overflow-x-auto">
            <table class="table-container">
                <thead>
                    <tr>
                        <th>Profil Resmi</th>
                        <th>İsim ve Mail</th>
                        <th>Kullanıcı Adı</th>
                        <th>Pozisyon</th>
                        <th>Mazeret</th>
                        <th>Talep Açılan Gün</th>
                        <th>İzin Talep Edilen Gün</th>
                        <th>Ek Belge</th>
                        <th>Onay Durumu</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $badgeColors = ['badge-orange', 'badge-green', 'badge-blue'];
                    @endphp
                    @foreach ($offdays as $index => $offday)
                        @php
                            $user = $offday->user;
                            $badgeColor = $badgeColors[$index % count($badgeColors)];
                        @endphp
                        <tr>
                            <td class="icon-container">
                                <img src="{{ asset('images/' . $user->profilePic) }}" alt="{{ $user->name }}" />
                            </td>
                            <td>
                                <div class="text-gray-900 font-semibold">{{ $user->name }}</div>
                                <div class="text-gray-500 text-sm">{{ $user->email }}</div>
                            </td>
                            <td class="text-gray-700">{{ $user->username }}</td>
                            <td>
                                <span class="badge {{ $badgeColor }}">{{ $user->gorev }}</span>
                            </td>
                            <td class="text-gray-700">{{ $offday->reason }}</td>
                            <td class="text-gray-700">{{ \Carbon\Carbon::parse($offday->created_at)->format('d/m/Y') }}
                            </td>
                            <td class="text-gray-700">{{ \Carbon\Carbon::parse($offday->offday_date)->format('d/m/Y') }}
                            </td>
                            <td>







                                @if ($offday->document)
                                    <a href="{{ route('attachments.download', ['filename' => basename($offday->document)]) }}"
                                        class="text-gray-500 hover:text-gray-700 transition" title="İndir">
                                        <i class="fa-solid fa-paperclip"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400">Belge yok</span>
                                @endif















                            </td>

                            <td>
                                @if ($offday->status == 'pending')
                                    <form action="{{ route('admin.offdays.approve', $offday->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        <button type="submit" class="btn-approve">Onayla</button>
                                    </form>
                                    <form action="{{ route('admin.offdays.reject', $offday->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        <button type="submit" class="btn-reject">Reddet</button>
                                    </form>
                                @else
                                    <span class="text-gray-600">{{ ucfirst($offday->status) }}</span>
                                @endif
                            </td>






                            <td>
                                <div class="dropdown">
                                    <button class="dropdown-toggle">
                                        <i class="fa-solid fa-ellipsis-v text-blue-600"></i>
                                    </button>
                                    <div class="dropdown-content">
                                        <a href="{{ route('admin.offdays.edit', $offday->id) }}">Düzenle</a>
                                        <form action="{{ route('admin.offdays.destroy', $offday->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Sil</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dropdowns = document.querySelectorAll('.dropdown');

            dropdowns.forEach(function(dropdown) {
                var toggle = dropdown.querySelector('.dropdown-toggle');
                var content = dropdown.querySelector('.dropdown-content');

                toggle.addEventListener('click', function(event) {
                    event.stopPropagation();
                    document.querySelectorAll('.dropdown-content').forEach(function(otherContent) {
                        if (otherContent !== content) {
                            otherContent.style.display = 'none';
                        }
                    });
                    content.style.display = content.style.display === 'block' ? 'none' : 'block';
                });

                document.addEventListener('click', function() {
                    content.style.display = 'none';
                });
            });
        });
    </script>
@endsection
