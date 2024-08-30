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

        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
                margin-right: 0;
            }
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
            position: relative;
            right: 0;
            top: 100%;
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
            padding: 0.5rem;
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

    <div class="main-content w-5/6 mx-auto p-4 ml-16 lg:w-full lg:ml-0">
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-3xl text-gray-600">
                <i class="fa-solid fa-life-ring mr-3 text-sky-500"></i> Destek Talepleri
            </h2>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center mb-5">
            <form action="{{ route('admin.users.search9') }}" method="GET" class="flex items-center mb-3 sm:mb-0">
                <input type="text" name="search" value="{{ request()->query('search') }}"
                    class="border rounded-lg px-4 py-2 w-80" placeholder="Kullanıcı adı ile ara...">
                <button type="submit"
                    class="ml-2 bg-sky-500 text-white px-4 py-2 rounded-lg hover:bg-sky-500 transition duration-300">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>


            <div class="flex items-center sm:ml-4">
                <p class="text-gray-600 underline">{{ $contacts->count() }} talep listeleniyor..</p>

            </div>
        </div>

        @if ($contacts->isEmpty())
            <p class="text-gray-500"> Hiç talep bulunamadı. <a href="{{ route('tasks.index') }}"
                    class="text-blue-500 underline"> Panele geri dön </a></p>
        @endif
        <div class="overflow-x-auto">
            <table class="table-container w-full">
                <thead>
                    <tr>
                        <th>Profil Resmi</th>
                        <th>İsim ve Mail</th>
                        <th>Kullanıcı Adı</th>
                        <th>Konu</th>
                        <th>Başlık</th>
                        <th>Mesaj</th>
                        <th>Tarih</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $badgeColors = [
                            'bg-orange-100 text-gray-600',
                            'bg-[#dcedc8] text-gray-600',
                            'bg-sky-100 text-gray-600',
                        ];
                    @endphp
                    @foreach ($contacts as $index => $contact)
                        @php
                            $user = $contact->user;
                            $badgeColor = $badgeColors[$index % count($badgeColors)];
                        @endphp
                        <tr>
                            <td class="icon-container">
                                <img src="{{ asset('images/' . $user->profilePic) }}" alt="{{ $user->name }}">
                            </td>
                            <td>
                                {{ $user->name }}
                                <p class="text-muted">{{ $user->email }}</p>
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>
                                <span class="inline-block rounded-full px-2 py-1 text-sm font-semibold {{ $badgeColor }}">
                                    {{ $contact->name }}
                                </span>
                            </td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->message }}</td>
                            <td>{{ $contact->created_at->format('d-m-Y H:i') }}</td>
                            <td class="relative">
                                <div class="dropdown flex justify-center text-blue-600">
                                    <button class="dropdown-toggle">
                                        <i class="fa-regular fa-life-ring"></i> </button>


                                    <div class="dropdown-content">


                                        <a href="{{ route('admin.contacts.show', $contact->id) }}"
                                            class="text-blue-600 hover:underline">Detaylar</a>




                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');"
                                            class="block">
                                            @csrf
                                            @method('DELETE')

                                            @if ($user->name !== 'admin')
                                            @endif
                                        </form>
                                    </div>





                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script>
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const dropdownContent = this.nextElementSibling;
                    dropdownContent.classList.toggle('show');
                });
            });

            document.addEventListener('click', function(e) {
                dropdownToggles.forEach(toggle => {
                    const dropdownContent = toggle.nextElementSibling;
                    if (!toggle.contains(e.target) && !dropdownContent.contains(e.target)) {
                        dropdownContent.classList.remove('show');
                    }
                });
            });
        </script>
    @endsection
