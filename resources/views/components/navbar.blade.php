<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <link rel="icon" type="image/x-icon" href="images/favLogo.png">

    <style>
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .sidebar-item {
            transition: all 0.3s, transform 0.3s;
            display: block;
            padding: 10px;
        }

        .sidebar-item:hover,
        .sidebar-item.active {
            background-color: #e0f2fe;
            color: #075985;
        }

        .logo-box {
            background-color: #0ea5e9;
            padding: 10px;
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .logo-box:hover {
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .sidebar {
                display: fixed;
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 100%;
                background: white;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                overflow-y: auto;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-toggle {
                display: block;
                font-size: 1.5rem;
                cursor: pointer;
                z-index: 1100;
                /* Ensure the toggle button is above other content */
            }
        }
    </style>
</head>

<body>
    <!-- Hamburger Menu -->
    <div class="lg:hidden p-4 relative">
        <span class="sidebar-toggle text-gray-600">
            <i class="fas fa-bars"></i>
        </span>
    </div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="sidebar fixed w-64 bg-white h-screen p-5 text-gray-600 rounded-xl md:w-1/4 lg:w-1/5 xl:w-1/6 ">

        <div class="flex items-center mb-20">
            <a href="{{ url('admin') }}" class="flex items-center">
                <div class="logo-box rounded-full">
                    <img src="{{ asset('images/logo1.png') }}" alt="logo" class="w-14" />
                </div>
            </a>
            <a href="{{ url('admin') }}" class="ml-2">
                <span class="font-quicksand text-2xl">Task Monitor</span>
            </a>
        </div>

        <ul id="sidebar-menu" class="space-y-4">
            <li>
                <a href="{{ route('admin') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fas fa-th-large mr-3"></i>
                    Admin Paneli
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.show') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-regular fa-id-card mr-3"></i>
                    Kullanıcılar
                </a>
            </li>
            <li>
                <a href="{{ route('projects.index') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-regular fa-file-code mr-4"></i>
                    Projeler
                </a>
            </li>
            <li>
                <a href="{{ route('mission.index') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-solid fa-layer-group mr-3"></i> Görevler
                </a>
            </li>
            <li>
                <a href="{{ route('admin.workSessions') }}"
                    class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-regular fa-clock mr-3"></i>
                    Mesai Takip
                </a>
            </li>
            <li>
                <a href="{{ route('admin.offdays.index') }}"
                    class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-regular fa-pen-to-square mr-3"></i>
                    İzin Takip
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reports.index') }}"
                    class="sidebar-item flex items-center text-lg text-gray-600">
                    <i class="fa-regular fa-copy mr-3"></i>
                    Raporlar
                </a>
            </li>
        </ul>

        <div class="mt-40">
            <div class="flex flex-col justify-center mt-auto gap-1 border-t border-gray-500 pt-1">
                <a href="{{ route('profile') }}"
                    class="text-gray-600 hover:text-sky-700 transition-colors duration-200 flex items-center gap-2 pl-2">
                    <i class="fas fa-cog text-md mr-1"></i>
                    <span class="text-md">Ayarlar</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="flex items-center gap-4 pl-2">
                    @csrf
                    <button type="submit"
                        class="text-gray-600 hover:text-sky-700 transition-colors duration-200 flex items-center gap-2">
                        <i class="fas fa-sign-out-alt text-md mb-1 mr-1"></i>
                        <span class="text-md mb-1">Çıkış Yap</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarItems = document.querySelectorAll('.sidebar-item');

            sidebarItems.forEach(item => {
                item.addEventListener('click', function() {
                    sidebarItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            const currentUrl = window.location.href;
            sidebarItems.forEach(item => {
                if (item.href === currentUrl) {
                    item.classList.add('active');
                }
            });

            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.querySelector('.sidebar-toggle');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
            });

            document.addEventListener('click', function(e) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            });
        });
    </script>
</body>

</html>
