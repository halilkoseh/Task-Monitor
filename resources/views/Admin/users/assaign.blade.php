@extends('layout.app')

@section('content')
    <style>
        .wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(20px);
            padding: 20px;
        }

        .sidebar {
            display: none; 
        }

        .form-container {
            max-width: 400px; 
            width: 100%;
            background-color: rgba(229, 231, 235, 0.8); 
            padding: 20px;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px); 
            display: flex;
            flex-direction: column;
            margin-left: 600px;
        }

        .form-container h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .form-container input, .form-container select, .form-container textarea {
            background-color: #f1f5f9; /* bg-slate-100 */
            color: #000000;
            backdrop-filter: blur(4px); /* Blur effect on input fields */
        }

        .form-container input::placeholder, .form-container textarea::placeholder {
            color: #6b7280; /* gray-400 */
        }

        .form-container input:focus, .form-container select:focus, .form-container textarea:focus {
            background-color: #ffffff;
            color: #000000;
        }

        .form-container .form-field {
            width: 100%;
            margin-bottom: 20px;
        }

        .form-container .form-field:last-child {
            margin-bottom: 0;
        }

        .form-container .flex-field {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .form-container .flex-field > div {
            flex: 1;
        }

        .form-container .flex-buttons {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .form-container .flex-buttons > a,
        .form-container .flex-buttons > button {
            flex: 1;
        }

        .form-container .required::before {
            content: "* ";
            color: red;
        }
    </style>

    <div class="wrapper">
        <div class="form-container">
            <h1 class="text-3xl font-semibold mb-8 text-gray-900">Görev Atama</h1>
            <form action="{{ route('admin.tasks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 w-full">
                @csrf

                <div class="form-field">
                    <label for="taskTitle" class="block text-gray-700 font-bold mb-2 required">Görev Başlığı</label>
                    <input type="text" id="taskTitle" name="taskTitle" class="shadow appearance-none border rounded-xl w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" placeholder="Görev Başlığı" required>
                </div>

                <div class="form-field">
                    <label for="taskDescription" class="block text-gray-700 font-bold mb-2 required">Görev Açıklaması</label>
                    <textarea id="taskDescription" name="taskDescription" class="shadow appearance-none border rounded-xl w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" placeholder="Görev Açıklaması" required></textarea>
                </div>

                <div class="form-field">
                    <label for="project" class="block text-gray-700 font-bold mb-2 required">Proje</label>
                    <select id="project" name="project" class="shadow appearance-none border rounded-xl w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="assignedUsers" class="form-field">
                    <label class="block text-gray-700 font-bold mb-2 required">Atanacak Kişi</label>
                    <div class="flex items-center space-x-2 w-full">
                        <select name="assignedTo[]" class="assignedTo shadow appearance-none border rounded-xl py-2 px-3 leading-tight focus:outline-none focus:shadow-outline flex-grow" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" id="addUserButton" class="bg-sky-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-xl focus:outline-none focus:shadow-outline">+</button>
                    </div>
                </div>

                <div class="flex-field form-field">
                    <div>
                        <label for="startDate" class="block text-gray-700 font-bold mb-2 required">Başlangıç Tarihi</label>
                        <input type="date" id="startDate" name="startDate" class="shadow appearance-none border rounded-xl w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div>
                        <label for="dueDate" class="block text-gray-700 font-bold mb-2 required">Bitiş Tarihi</label>
                        <input type="date" id="dueDate" name="dueDate" class="shadow appearance-none border rounded-xl w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                </div>

                <div class="form-field">
                    <label for="attachments" class="block text-gray-700 font-bold mb-2">Ek Materyaller</label>
                    <input type="file" id="attachments" name="attachments" class="shadow appearance-none border rounded-xl w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="flex-buttons form-field">
                    <button type="submit" class="bg-sky-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Görevi Ata</button>
                    <a href="{{ route('admin') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center">İptal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addUserButton = document.getElementById('addUserButton');
            const assignedUsersDiv = document.getElementById('assignedUsers');
            const projectSelect = document.getElementById('project');

            addUserButton.addEventListener('click', function() {
                const userSelectGroup = document.createElement('div');
                userSelectGroup.classList.add('flex', 'items-center', 'space-x-2', 'mb-4');

                const selectClone = assignedUsersDiv.querySelector('.assignedTo').cloneNode(true);
                selectClone.classList.add('flex-grow');
                userSelectGroup.appendChild(selectClone);

                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.classList.add('bg-red-500', 'hover:bg-red-600', 'text-white', 'font-bold', 'py-2', 'px-4', 'rounded-xl', 'focus:outline-none', 'focus:shadow-outline', 'w-full', 'mt-2');
                removeButton.textContent = '-';

                removeButton.addEventListener('click', function() {
                    assignedUsersDiv.removeChild(userSelectGroup);
                });

                userSelectGroup.appendChild(removeButton);
                assignedUsersDiv.appendChild(userSelectGroup);

                projectSelect.addEventListener('change', function() {
                    const projectId = this.value;
                    fetch(`/admin/projects/${projectId}/users/assaign`)
                        .then(response => response.json())
                        .then(users => {
                            const userSelects = assignedUsersDiv.querySelectorAll('.assignedTo');
                            userSelects.forEach(select => {
                                select.innerHTML = '';
                                users.forEach(user => {
                                    const option = document.createElement('option');
                                    option.value = user.id;
                                    option.textContent = user.name;
                                    select.appendChild(option);
                                });
                            });
                        })
                        .catch(error => console.error('Error fetching project users:', error));
                });
            });
        });
    </script>
@endsection
