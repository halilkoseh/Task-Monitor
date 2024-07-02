@extends('layout.app')

@section('content')
<div class="flex-1 p-8 mt-8">
    <h1 class="text-3xl font-semibold text-center mb-8 text-gray-900">Görev Atama</h1>

    <form class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg space-y-6" action="{{ route('admin.tasks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="taskTitle" class="block text-gray-700 font-bold mb-2">Görev Başlığı</label>
            <input type="text" id="taskTitle" name="taskTitle" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Görev Başlığı" required>
        </div>

        <div class="mb-4">
            <label for="taskDescription" class="block text-gray-700 font-bold mb-2">Görev Açıklaması</label>
            <textarea id="taskDescription" name="taskDescription" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Görev Açıklaması" required></textarea>
        </div>
        
        <div class="mb-4">
            <label for="project" class="block text-gray-700 font-bold mb-2">Proje</label>
            <select id="project" name="project" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>

        <div id="assignedUsers" class="space-y-4">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Atanacak Kişi</label>
                <select name="assignedTo[]" class="assignedTo shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="button" id="addUserButton" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Collaborator Ekle</button>

        <div class="mb-4">
            <label for="startDate" class="block text-gray-700 font-bold mb-2">Başlangıç Tarihi</label>
            <input type="date" id="startDate" name="startDate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="dueDate" class="block text-gray-700 font-bold mb-2">Bitiş Tarihi</label>
            <input type="date" id="dueDate" name="dueDate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="attachments" class="block text-gray-700 font-bold mb-2">Ek Materyaller</label>
            <input type="file" id="attachments" name="attachments" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Görevi Ata</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addUserButton = document.getElementById('addUserButton');
        const assignedUsersDiv = document.getElementById('assignedUsers');
        const projectSelect = document.getElementById('project');

        addUserButton.addEventListener('click', function() {
            const userSelectGroup = document.createElement('div');
            userSelectGroup.classList.add('mb-4');

            const selectClone = assignedUsersDiv.querySelector('.assignedTo').cloneNode(true);
            userSelectGroup.appendChild(selectClone);

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.classList.add('bg-red-500', 'hover:bg-red-600', 'text-white', 'font-bold', 'py-2', 'px-4', 'rounded', 'focus:outline-none', 'focus:shadow-outline', 'w-full', 'mt-2');
            removeButton.textContent = 'Kullanıcıyı Çıkar';

            removeButton.addEventListener('click', function() {
                assignedUsersDiv.removeChild(userSelectGroup);
            });

            userSelectGroup.appendChild(removeButton);
            assignedUsersDiv.appendChild(userSelectGroup);
        });

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
</script>

@endsection
