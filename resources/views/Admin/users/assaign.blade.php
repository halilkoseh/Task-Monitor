@extends('layout.app')
<style>
    .blurred {
        filter: blur(5px);
    }
</style>

@section('content')
    <div id="mainContent" class="flex-1 p-8 mt-8 ml-32 ">



        <form class=" mx-auto bg-white p-8 rounded-lg shadow-lg space-y-6 w-1/2" action="{{ route('admin.tasks.store') }}"
            method="POST" enctype="multipart/form-data" id="taskForm">
            @csrf

            <h1 class="text-3xl font-semibold text-center mb-8 text-gray-900">Görev Atama</h1>

            <div class="mt-6 mb-6">
                <a href="{{ route('mission.index') }}" class="text-sky-500 hover:text-blue-800">
                    <i class="fa-solid fa-chevron-left"></i> Geri Dön
                </a>
            </div>


            

            <div class="mb-4">
                <label for="taskTitle" class="block text-gray-700 font-bold mb-2">Görev Başlığı</label>
                <input type="text" id="taskTitle" name="taskTitle"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Görev Başlığı" required>
            </div>

            <div class="mb-4">
                <label for="taskDescription" class="block text-gray-700 font-bold mb-2">Görev Açıklaması</label>
                <textarea id="taskDescription" name="taskDescription"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Görev Açıklaması" required></textarea>
            </div>

            <div class="mb-4">
                <label for="project" class="block text-gray-700 font-bold mb-2">Proje</label>
                <select id="project" name="project"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="assignedUsers" class="space-y-4">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Atanacak Kişi</label>
                    <select name="assignedTo[]"
                        class="assignedTo shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="button" id="addUserButton"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Collaborator
                Ekle</button>

            <div class="mb-4">
                <label for="startDate" class="block text-gray-700 font-bold mb-2">Başlangıç Tarihi</label>
                <input type="date" id="startDate" name="startDate"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>

            <div class="mb-4">
                <label for="dueDate" class="block text-gray-700 font-bold mb-2">Bitiş Tarihi</label>
                <input type="date" id="dueDate" name="dueDate"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>

            <div class="mb-4">
                <label for="attachments" class="block text-red-700 font-bold mb-2">Ek Materyaller (.zip)</label>
                <input type="file" id="attachments" name="attachments"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    accept=".zip">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Görevi
                    Ata</button>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div id="taskModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-xl max-w-sm mx-auto text-center relative">
            <i class="fa-regular fa-thumbs-up text-green-600 text-4xl mb-4"></i>
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Görev Atandı!</h2>
            <p class="text-gray-600 mb-6">Göreviniz başarıyla atanmıştır.</p>
            <button id="closeModal"
                class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-full shadow-md transition-transform transform hover:scale-105">
                Tamam
            </button>
            <button id="closeButton" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addUserButton = document.getElementById('addUserButton');
            const assignedUsersDiv = document.getElementById('assignedUsers');
            const projectSelect = document.getElementById('project');
            const taskForm = document.getElementById('taskForm');
            const taskModal = document.getElementById('taskModal');
            const closeModalButton = document.getElementById('closeModal');
            const mainContent = document.getElementById('mainContent');

            function showModal() {
                taskModal.classList.remove('hidden');
                mainContent.classList.add('blurred');
            }

            function hideModal() {
                taskModal.classList.add('hidden');
                mainContent.classList.remove('blurred');
            }

            addUserButton.addEventListener('click', function() {
                const userSelectGroup = document.createElement('div');
                userSelectGroup.classList.add('mb-4');

                const selectClone = assignedUsersDiv.querySelector('.assignedTo').cloneNode(true);
                userSelectGroup.appendChild(selectClone);

                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.classList.add('bg-red-500', 'hover:bg-red-600', 'text-white', 'font-bold',
                    'py-2', 'px-4', 'rounded', 'focus:outline-none', 'focus:shadow-outline', 'w-full',
                    'mt-2');
                removeButton.textContent = 'Kullanıcıyı Çıkar';

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
                            const userSelects = assignedUsersDiv.querySelectorAll(
                                '.assignedTo');
                            userSelects.forEach(select => {
                                select.innerHTML = '';
                                users.forEach(user => {
                                    const option = document.createElement(
                                        'option');
                                    option.value = user.id;
                                    option.textContent = user.name;
                                    select.appendChild(option);
                                });
                            });
                        })
                        .catch(error => console.error('Error fetching project users:', error));
                });
            });

            taskForm.addEventListener('submit', function(event) {
                event.preventDefault();

                fetch(taskForm.action, {
                        method: 'POST',
                        body: new FormData(taskForm),
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            showModal();
                            taskForm.reset();
                            setTimeout(() => {
                                hideModal();
                            }, 3000);
                        } else {
                            alert('Görev atanamadı, lütfen tekrar deneyin.');
                        }
                    })
                    .catch(error => {
                        console.error('Error submitting the form:', error);
                        alert('Görev atanamadı, lütfen tekrar deneyin.');
                    });
            });

            closeModalButton.addEventListener('click', hideModal);
        });
    </script>
@endsection
