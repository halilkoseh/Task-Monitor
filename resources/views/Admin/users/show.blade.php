@extends('layout.app')

@section('content')
<style>
    .main-content {
        padding: 20px;
    }

    .table-container {
        max-width: 100%;
    }

    .table-container table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-container th,
    .table-container td {
        padding: 0.75rem;
        text-align: left;
    }

    .card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
    }

    .custom-input {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        background-color: #ffffff;
        font-size: 1rem;
        color: #4a5568;
        transition: all 0.3s ease;
    }

    .custom-input:focus {
        border-color: #63b3ed;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
    }

    .custom-button {
        background-color: #3182ce;
        color: #ffffff;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .custom-button:hover {
        background-color: #2b6cb0;
    }

    .custom-button:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
    }
</style>

<div class="main-content w-5/6 p-5 mt-2">
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-3xl">
            <i class="fas fa-users mr-3 text-blue-500"></i> Kullanıcı Listesi
        </h2>
        <button id="addUserBtn"
            class="bg-blue-500 text-white px-6 py-3 rounded-full hover:bg-blue-600 transform hover:scale-110 transition duration-300">
            <span class="text-lg font-semibold">+ Kullanıcı Ekle</span>
        </button>
    </div>
    <div class="bg-white shadow-md rounded p-5 table-container">
        <div id="userListContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    
        </div>
    </div>
</div>

<div id="addUserFormModal"
    class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white shadow-lg rounded-2xl p-6 w-1/3">
        <h3 class="text-2xl font-bold mb-4">Kullanıcı Ekle</h3>
        <form id="userForm" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="name">İsim-Soyisim</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="İsim-Soyisim">
            </div>
            <div class="mb-4 flex">
                <div class="w-1/2 pr-2">
                    <label class="block text-sm font-bold mb-2" for="username">Kullanıcı Adı</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Kullanıcı Adı">
                </div>
                <div class="w-1/2 pl-2">
                    <label class="block text-sm font-bold mb-2" for="password">Şifre</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="Şifre">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="jobPosition">Görevi</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="jobPosition" type="text" placeholder="Görevi">
            </div>
            <div class="mb-4 flex">
                <div class="w-1/2 pr-2">
                    <label class="block text-sm font-bold mb-2" for="emailAddress">E-posta Adresi</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="emailAddress" type="email" placeholder="E-posta Adresi">
                </div>
                <div class="w-1/2 pl-2">
                    <label class="block text-sm font-bold mb-2" for="phoneNumber">Telefon</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="phoneNumber" type="tel" placeholder="Telefon">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="linkedinAddress">LinkedIn Adresi</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="linkedinAddress" type="url" placeholder="LinkedIn Adresi">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="portfolioLink">Portföy Linki</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="portfolioLink" type="url" placeholder="Portföy Linki">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="profilePic">Profil Resmi</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="profilePic" type="file" accept="image/*">
            </div>
            <div class="flex items-center justify-between">
                <button id="submitUserBtn" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Kullanıcı Ekle</button>
                <button id="cancelUserBtn" type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">İptal</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-......" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.getElementById('userForm').addEventListener('submit', function (e) {
        e.preventDefault();
        addUser();
        document.getElementById('addUserFormModal').classList.add('hidden');
    });

    document.getElementById('addUserBtn').addEventListener('click', function () {
        document.getElementById('addUserFormModal').classList.remove('hidden');
    });

    document.getElementById('cancelUserBtn').addEventListener('click', function () {
        document.getElementById('addUserFormModal').classList.add('hidden');
    });

    function loadUsers() {
        const users = JSON.parse(localStorage.getItem('users')) || [];
        users.forEach(user => addUserToTable(user));
    }

    function saveUser(user) {
        const users = JSON.parse(localStorage.getItem('users')) || [];
        users.push(user);
        localStorage.setItem('users', JSON.stringify(users));
    }

    function addUser() {
        const name = document.getElementById('name').value;
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const jobPosition = document.getElementById('jobPosition').value;
        const emailAddress = document.getElementById('emailAddress').value;
        const phoneNumber = document.getElementById('phoneNumber').value;
        const linkedinAddress = document.getElementById('linkedinAddress').value;
        const portfolioLink = document.getElementById('portfolioLink').value;
        const profilePic = document.getElementById('profilePic').files[0];

        const reader = new FileReader();
        reader.onload = function (e) {
            const newUser = {
                name,
                username,
                password,
                jobPosition,
                emailAddress,
                phoneNumber,
                linkedinAddress,
                portfolioLink,
                profilePic: e.target.result
            };

            saveUser(newUser);
            addUserToTable(newUser);
            clearForm();
        };

        if (profilePic) {
            reader.readAsDataURL(profilePic);
        } else {
            const newUser = {
                name,
                username,
                password,
                jobPosition,
                emailAddress,
                phoneNumber,
                linkedinAddress,
                portfolioLink,
                profilePic: 'default-profile-pic-url' 
            };

            saveUser(newUser);
            addUserToTable(newUser);
            clearForm();
        }
    }

    function clearForm() {
        document.getElementById('userForm').reset();
    }

    function addUserToTable(user) {
        const userListContainer = document.getElementById('userListContainer');

        const card = document.createElement('div');
        card.classList.add('card', 'flex', 'items-center', 'justify-between');

        const userInfo = `
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-full overflow-hidden">
                    <img src="${user.profilePic}" alt="${user.name}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 class="font-semibold text-lg">${user.name}</h3>
                    <p class="text-gray-600">${user.jobPosition}</p>
                </div>
            </div>
            <div class="flex space-x-4">
                <a href="mailto:${user.emailAddress}" class="text-gray-500 hover:text-blue-500">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="tel:${user.phoneNumber}" class="text-gray-500 hover:text-blue-500">
                    <i class="fas fa-phone"></i>
                </a>
                <a href="${user.linkedinAddress}" class="text-gray-500 hover:text-blue-500">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="${user.portfolioLink}" class="text-gray-500 hover:text-blue-500">
                    <i class="fas fa-link"></i>
                </a>
            </div>
            <div class="mb-10">
                <button class="text--500" onclick="editUser('${user.username}')">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="text-red-500" onclick="deleteUser('${user.username}')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;

        card.innerHTML = userInfo;
        userListContainer.appendChild(card);
    }

    function editUser(username) {
        const users = JSON.parse(localStorage.getItem('users')) || [];
        const user = users.find(u => u.username === username);

        if (user) {
            document.getElementById('name').value = user.name;
            document.getElementById('username').value = user.username;
            document.getElementById('password').value = user.password;
            document.getElementById('jobPosition').value = user.jobPosition;
            document.getElementById('emailAddress').value = user.emailAddress;
            document.getElementById('phoneNumber').value = user.phoneNumber;
            document.getElementById('linkedinAddress').value = user.linkedinAddress;
            document.getElementById('portfolioLink').value = user.portfolioLink;
  

            document.getElementById('addUserFormModal').classList.remove('hidden');

            document.getElementById('userForm').addEventListener('submit', function (e) {
                e.preventDefault();
                updateUser(username);
            });
        }
    }

    function updateUser(username) {
        const users = JSON.parse(localStorage.getItem('users')) || [];
        const userIndex = users.findIndex(u => u.username === username);

        if (userIndex !== -1) {
            users[userIndex] = {
                name: document.getElementById('name').value,
                username: document.getElementById('username').value,
                password: document.getElementById('password').value,
                jobPosition: document.getElementById('jobPosition').value,
                emailAddress: document.getElementById('emailAddress').value,
                phoneNumber: document.getElementById('phoneNumber').value,
                linkedinAddress: document.getElementById('linkedinAddress').value,
                portfolioLink: document.getElementById('portfolioLink').value,
                profilePic: users[userIndex].profilePic
            };

            localStorage.setItem('users', JSON.stringify(users));
            document.getElementById('addUserFormModal').classList.add('hidden');
            document.getElementById('userListContainer').innerHTML = '';
            loadUsers();
        }
    }

    function deleteUser(username) {
        let users = JSON.parse(localStorage.getItem('users')) || [];
        users = users.filter(user => user.username !== username);
        localStorage.setItem('users', JSON.stringify(users));
        document.getElementById('userListContainer').innerHTML = '';
        loadUsers();
    }

    document.addEventListener('DOMContentLoaded', function () {
        loadUsers();
    });
</script>
@endsection
