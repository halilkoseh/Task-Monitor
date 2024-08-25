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
            padding: 10px;
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .logo-box:hover {
            transform: scale(1.1);
        }


        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .content-container {
            min-height: 100vh;
            margin-left: 16rem;
            padding: 20px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="flex">
        <div class="fixed w-64 bg-white h-screen p-5 text-gray-600 rounded-xl md:w-1/4 lg:w-1/5 xl:w-1/6">




            <div class="flex items-center mb-20">
                <a href="{{ url('user') }}" class="flex items-center">
                    <div class="logo-box rounded-full">
                        <img src="{{ asset('images/favLogo.png') }}" alt="logo" class="w-14" />
                    </div>
                </a>
                <a href="{{ url('user') }}" class="ml-2">
                    <span class="font-quicksand text-2xl">Task Monitor</span>
                </a>
            </div>






            <ul id="sidebar-menu" class="space-y-4">
                <li>
                    <a href="{{ route('user') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                        <i class="fas fa-th-large mr-3"></i>
                        Kullanıcı Paneli
                    </a>
                </li>







                <li>
                    <a href="{{ route('user.workSessions') }}"
                        class="sidebar-item flex items-center text-lg text-gray-600">
                        <i class="fa-regular fa-clock mr-3"></i>
                        Mesai Giriş Çıkış
                    </a>
                </li>


                <li>
                    <a href="{{ route('offday.index') }}" class="sidebar-item flex items-center text-lg text-gray-600">
                        <i class="fa-regular fa-pen-to-square mr-3"></i>
                        İzin Talep
                    </a>
                </li>









            </ul>



            <div class="mt-40">
                <div class="flex flex-col justify-center mt-auto gap-4 border-t border-gray-300 pt-4">
                    <a href="{{ route('profile') }}"
                        class="flex items-center gap-3 pl-4 py-2 rounded-md hover:bg-sky-100 transition-colors duration-300 group">
                        <i class="fas fa-cog text-lg text-gray-500 group-hover:text-sky-700"></i>
                        <span class=" font-medium text-gray-700 group-hover:text-sky-700">Ayarlar</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 pl-4 py-2 w-full rounded-md hover:bg-red-100 transition-colors duration-300 group">
                            <i class="fas fa-sign-out-alt text-lg text-gray-500 group-hover:text-red-700"></i>
                            <span class=" font-medium text-gray-700 group-hover:text-red-700">Çıkış Yap</span>
                        </button>
                    </form>
                </div>
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
        });
    </script>
</body>

</html>
