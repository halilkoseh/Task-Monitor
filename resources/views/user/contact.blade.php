@extends('userLayout.app') @section('content')

<head>
    <meta charset="UTF-8" />
    <title>Task Monitor</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<div id="contact" class="w-screen max-w-4xl mx-auto px-6 py-12 md:px-16 border-2 border-white bg-white rounded-lg shadow-lg mt-32 mr-64 mb-32">
    <div class="bg-white p-8 rounded-lg shadow-lg mb-8 max-w-lg mx-auto border border-gray-200 text-center">
        <h1 class="text-4xl font-extrabold mb-6 text-gray-800 flex justify-center items-center"><i class="fa-solid fa-headset mr-4 text-blue-600"></i> Destek</h1>
        <p class="text-gray-700 text-lg leading-relaxed mb-6">
            Yöneticinizle iletişime geçmek için<br />
            lütfen aşağıdaki iletişim formunu kullanın.
        </p>
    </div>

    <div class="flex flex-col md:flex-row justify-center items-center">
        <!-- Left contact page -->
        <form id="contact-form" class="w-full md:w-1/2 space-y-6 mt-8" role="form" action="{{ route('contact.store') }}" method="POST">
            @csrf

            <div>
                <label for="name" class="block text-gray-700 font-medium">Talebiniz Ne ile Alakalı?</label>
                <select id="name" name="name" class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <option value="" disabled selected>Bir Başlığı Seçiniz</option>
                    <option value="Task Destek Talebi">Task Destek Talebi</option>
                    <option value="Mesai Destek Talebi">Mesai Destek Talebi</option>
                    <option value="İzin Destek Talebi">İzin Destek Talebi</option>
                    <option value="Profil Destek Talebi">Profil Destek Talebi</option>
                    <option value="Sistem Destek Talebi">Sistem Destek Talebi</option>
                </select>
            </div>

            <div>
                <label for="email" class="block text-gray-700 font-medium">Konu</label>
                <input
                    type="text"
                    id="email"
                    name="email"
                    class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    placeholder="Konu Giriniz"
                />
            </div>
            <div>
                <label for="message" class="block text-gray-700 font-medium">Mesajınız</label>
                <textarea
                    id="message"
                    name="message"
                    rows="4"
                    required
                    class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    placeholder="Mesajınızı Buraya Yazınız"
                ></textarea>
            </div>
            <button type="submit" id="submit-btn" required class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Gönder
            </button>
        </form>

        <!-- Right contact page -->
        <div class="w-full md:w-1/2 mt-10 md:mt-0 space-y-8 md:ml-16">
            <br />
            <ul class="space-y-4 text-[#535353]">
                <li class="flex items-center text-lg">
                    <i class="fas fa-map-marker-alt text-3xl mr-4 text-blue-500"></i>
                    <span>İstanbul, Küçükçekmece</span>
                </li>
                <li class="flex items-center text-lg">
                    <i class="fas fa-phone text-3xl mr-4 text-blue-500"></i>
                    <span><a href="tel:1-212-555-5555" class="hover:text-blue-400">+90 538 200 44 66</a></span>
                </li>

                <li class="flex items-center text-lg">
                    <i class="fas fa-envelope text-3xl mr-4 text-blue-500"></i>
                    <span><a href="mailto:hitmeup@gmail.com" class="hover:text-blue-400">info@taskmonitor.com</a></span>
                </li>
            </ul>

            <div class="border-t border-gray-700"></div>

            <ul class="flex justify-center space-x-6 text-3xl">
                <li>
                    <a href="#" target="_blank" class="hover:text-[#7F7F7F]"><i class="fab fa-github"></i></a>
                </li>
                <li>
                    <a href="#" target="_blank" class="hover:text-[#7F7F7F]"><i class="fab fa-codepen"></i></a>
                </li>
                <li>
                    <a href="#" target="_blank" class="hover:text-[#7F7F7F]"><i class="fab fa-twitter"></i></a>
                </li>
                <li>
                    <a href="#" target="_blank" class="hover:text-[#7F7F7F]"><i class="fab fa-instagram"></i></a>
                </li>
            </ul>

            <div class="border-t border-gray-700 mt-4"></div>

            <div class="text-center text-gray-500 text-sm">
                &copy; Tüm Hakları Saklıdır. <br />
                Task Monitor 2024
            </div>
        </div>
    </div>
</div>

<div id="popup-message" class="fixed inset-0 flex items-center justify-center bg-opacity-70 hidden ml-8 ">
    <div class="bg-[#EDF6FF] p-8 rounded-lg shadow-2xl max-w-sm w-full ml-8 ">
        <div class="flex items-center justify-center mb-4 ">
            <i class="fa-solid fa-thumbs-up text-green-500 text-3xl"></i>
        </div>
        <p class="text-lg font-semibold text-gray-800 ml-8">
            Mesajınız yöneticiye iletilmiştir. <br />
            Mail gelen kutusunu takip ediniz.
        </p>
        <div class="mt-6 flex justify-center">
            <button onclick="closePopup()" class="bg-[#2463EB] hover:bg-green-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-green-300 transition duration-300">Tamam</button>
        </div>
    </div>
</div>

<script>
    function closePopup() {
        document.getElementById("popup-message").classList.add("hidden");
    }
</script>

<script>
    document.getElementById("contact-form").addEventListener("submit", function (event) {
        event.preventDefault();

        var popup = document.getElementById("popup-message");
        popup.classList.remove("hidden");

        setTimeout(function () {
            popup.classList.add("hidden");
            event.target.submit();
        }, 1000);
    });

    function closePopup() {
        document.getElementById("popup-message").classList.add("hidden");
    }
</script>
@endsection
