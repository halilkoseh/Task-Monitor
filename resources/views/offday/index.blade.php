@extends('userLayout.app')

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
            margin-top: 10px;
        }

        .table-container th {
            background-color: #e9ecef;
            font-weight: 600;
            margin-top: 10px;
        }

        .table-container td {
            border-bottom: 1px solid #dee2e6;
            margin-top: 10px;
        }

        .table-container tr {
            background-color: #ffffff;
            transition: background-color 0.2s;
            margin-top: 10px;
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
            <div>
                <h2 class="text-3xl text-gray-600">
                    <i class="fa-regular fa-pen-to-square text-sky-500"></i> İzin Taleplerim
                </h2>
            </div>
            <div class="mt-4">
                <a href="{{ route('offday.create') }}"
                    class="inline-block mb-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    <i class="fa-solid fa-calendar-plus mr-2"></i> Yeni İzin Talebi Oluştur
                </a>
            </div>
        </div>

        <div class="overflow-x-auto mb-8">
            <table class="table-container mb-8">
                <thead class="mb-8">
                    <tr class="mt-16">
                        <th>Profil Resmi</th>
                        <th>İsim ve Mail</th>
                        <th>Kullanıcı Adı</th>
                        <th>Pozisyon</th>
                        <th>Mazeret</th>
                        <th>Talep Açılan Gün</th>
                        <th>İzin Talep Edilen Gün(ler)</th>
                        <th>Ek Belge</th>
                        <th class="">Durum</th>
                    </tr>
                </thead>

                <tbody class="mt-16">
                    @php
                        // Group offdays by the created date
                        $groupedOffdays = $offdays->groupBy(function ($offday) {
                            return \Carbon\Carbon::parse($offday->created_at)->format('d/m/Y');
                        });
                    @endphp

                    @foreach ($groupedOffdays as $date => $offdayGroup)
                        <tr>
                            <td colspan="9" class="py-4 bg-[#EDF6FF]"></td>
                        </tr>
                        <tr class="mt-16">
                            <td colspan="9" class="text-white font-semibold bg-[#535353] text-center">
                                {{ $date }}
                            </td>
                        </tr>
                        <tr>
                        </tr>
                        @foreach ($offdayGroup as $offday)
                            @php
                                $user = $offday->user;
                                $badgeColor = ['badge-orange', 'badge-green', 'badge-blue'][rand(0, 2)];
                            @endphp
                            <tr>
                                <td class="icon-container mt-2">
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
                                <td class="text-gray-700">
                                    {{ \Carbon\Carbon::parse($offday->offday_date)->format('d/m/Y') }}</td>
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
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $offday->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($offday->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $offday->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
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
                    // Close other dropdowns
                    document.querySelectorAll('.dropdown-content').forEach(function(otherContent) {
                        if (otherContent !== content) {
                            otherContent.style.display = 'none';
                        }
                    });
                    // Toggle the clicked dropdown
                    content.style.display = content.style.display === 'block' ? 'none' : 'block';
                });

                document.addEventListener('click', function() {
                    content.style.display = 'none';
                });
            });
        });
    </script>
@endsection
