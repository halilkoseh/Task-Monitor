@extends('layout.app')

@section('content')

<style>
    /* Custom styles for the page */
    .bg-sidebar {
        background-color: #3A6EA5;
    }

    .bg-task {
        background-color: #EBEBEB;
    }

    /* Form modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        border-radius: 10px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Button enlarge animation */
    #add-task-btn {
        transition: transform 0.3s ease;
    }

    #add-task-btn:active {
        transform: scale(1.1);
    }

    /* Input group styles */
    .input-group {
        display: flex;
        align-items: center;
        position: relative;
    }

    .input-group i {
        position: absolute;
        left: 10px;
        color: #6b7280;
    }

    .form-input {
        padding-left: 2.5rem;
    }

    /* Input and button spacing */
    .mb-2 {
        margin-bottom: 1rem;
    }

    .space-y-2>*+* {
        margin-top: 1rem;
    }

    .task-card {
        background-color: #fff;
        padding: 1rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }

    .task-card h3 {
        margin: 0 0 0.5rem;
    }

    .task-card span {
        display: block;
        margin-top: 0.5rem;
        color: #6b7280;
    }
</style>

<div class="flex">
    <!-- Main content -->
    <div class="flex-1 p-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-3xl">
                <i class="fa-solid fa-list-check mr-3 text-blue-500"></i> Görev Listesi
            </h1>
            <div class="flex items-center">
                <span id="current-date">Temmuz 16, 2024</span>
                <button id="date-picker-btn" class="ml-4 p-2 bg-gray-200 rounded-full">
                    <i class="fas fa-calendar-alt"></i>
                </button>
                <button id="add-task-btn" class="ml-4 p-2 bg-blue-500 text-white rounded-full">+ Görev Ata</button>
            </div>
        </div>
        <!-- Stats -->
        <div class="grid grid-cols-2 gap-4 mt-6">
            <div class="bg-white p-6 rounded-2xl shadow card">
                <h2 class="text-lg font-bold">Katılımcılar</h2>
                <div class="flex items-center mt-2">
                    <img src="avatar1.jpg" class="w-8 h-8 rounded-full mr-2">
                    <img src="avatar2.jpg" class="w-8 h-8 rounded-full mr-2">
                    <img src="avatar3.jpg" class="w-8 h-8 rounded-full mr-2">
                    <span class="ml-2">+12</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow card">
                <h2 class="text-lg font-bold">Zaman</h2>
                <div class="flex items-center mt-2">
                    <span class="text-2xl font-bold">1:40</span>
                </div>
            </div>
        </div>
        <!-- Task columns -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-6">
            <div class="bg-assigned p-4 rounded-2xl shadow card bg-yellow-100">
                <h2 class="text-lg font-bold text-yellow-600">Atandı</h2>
                <div class="mt-2">
                    <div class="task-card">
                        <h3>Extra Sistem</h3>
                        <span>Mobil</span>
                        <span>Mayıs 10, 2023</span>
                    </div>
                    <div class="task-card">
                        <h3>Kurummsal İK</h3>
                        <span>Web</span>
                        <span>Eylül 16, 2024</span>
                    </div>
                </div>
            </div>
            <div class="bg-started p-4 rounded-2xl shadow card bg-blue-100">
                <h2 class="text-lg font-bold text-blue-600">Başladı</h2>
                <div class="mt-2">
                 
                </div>
            </div>
            <div class="bg-in-progress p-4 rounded-2xl shadow card bg-green-100">
                <h2 class="text-lg font-bold text-green-600">Devam Ediyor</h2>
                <div class="mt-2">
                   
                </div>
            </div>
            <div class="bg-testing p-4 rounded-2xl shadow card bg-purple-100">
                <h2 class="text-lg font-bold text-purple-600">Test Ediliyor</h2>
                <div class="mt-2">
             
                </div>
            </div>
            <div class="bg-completed p-4 rounded-2xl shadow card bg-red-100">
                <h2 class="text-lg font-bold text-red-600">Tamamlandı</h2>
                <div class="mt-2">
               
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Task Modal -->
<div id="add-task-modal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-modal">&times;</span>
        <h2 class="text-2xl font-bold mb-4">Görev Atama</h2>
        <form id="add-task-form" class="space-y-4">
            <div class="input-group mb-2">
                <i class="fas fa-heading"></i>
                <input type="text" id="taskTitle" name="taskTitle" class="form-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Görev Başlığı" required>
            </div>
            <div class="input-group mb-2">
                <i class="fas fa-align-left"></i>
                <textarea id="taskDescription" name="taskDescription" class="form-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Görev Açıklaması" required></textarea>
            </div>
            <div class="input-group mb-2">
                <i class="fas fa-clipboard-list"></i>
                <input type="text" id="project" name="project" class="form-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Proje" required>
            </div>
            <div id="assignedUsers" class="space-y-2">
                <div class="input-group mb-2">
                    <i class="fas fa-user"></i>
                    <input type="text" id="assignedTo" name="assignedTo[]" class="form-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Atanacak Kişi" required>
                </div>
            </div>
            <button type="button" id="addUserButton" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Collaborator Ekle</button>
            <div class="input-group mb-2">
                <i class="fas fa-calendar-alt"></i>
                <input type="date" id="startDate" name="startDate" class="form-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="input-group mb-2">
                <i class="fas fa-calendar-check"></i>
                <input type="date" id="dueDate" name="dueDate" class="form-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="input-group mb-2">
                <i class="fas fa-paperclip"></i>
                <input type="file" id="attachments" name="attachments" class="form-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Görevi Ata</button>
            </div>
        </form>
    </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Add task modal
        const addTaskBtn = document.getElementById('add-task-btn');
        const addTaskModal = document.getElementById('add-task-modal');
        const closeModal = document.getElementById('close-modal');
        const addTaskForm = document.getElementById('add-task-form');
        const addUserButton = document.getElementById('addUserButton');
        const assignedUsersDiv = document.getElementById('assignedUsers');

        addTaskBtn.addEventListener('click', () => {
            addTaskModal.style.display = 'flex';
        });

        closeModal.addEventListener('click', () => {
            addTaskModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === addTaskModal) {
                addTaskModal.style.display = 'none';
            }
        });

        addTaskForm.addEventListener('submit', (e) => {
            e.preventDefault();
            addTaskModal.style.display = 'none';
            alert('Görev atandı!');
        });

   
        const datePickerBtn = document.getElementById('date-picker-btn');
        const currentDate = document.getElementById('current-date');

        datePickerBtn.addEventListener('click', () => {
            const date = prompt('Tarih girin (YYYY-MM-DD):');
            if (date) {
                currentDate.textContent = new Date(date).toLocaleDateString();
            }
        });

        addUserButton.addEventListener('click', () => {
            const userSelectGroup = document.createElement('div');
            userSelectGroup.classList.add('space-y-2');

            const selectClone = document.createElement('div');
            selectClone.classList.add('input-group', 'mb-2');
            selectClone.innerHTML = `
                <i class="fas fa-user"></i>
                <input type="text" name="assignedTo[]" class="form-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Atanacak Kişi" required>
                <button type="button" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-2 w-full">Kullanıcıyı Çıkar</button>
            `;

            userSelectGroup.appendChild(selectClone);

            assignedUsersDiv.appendChild(userSelectGroup);

            selectClone.querySelector('button').addEventListener('click', () => {
                assignedUsersDiv.removeChild(userSelectGroup);
            });
        });
    });
</script>

@endsection
