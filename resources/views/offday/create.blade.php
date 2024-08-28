@extends('userLayout.app')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg mt-64">

        <div class="mt-6 mb-6">
            <a href="{{ route('offday.index') }}" class="text-sky-500 hover:text-blue-800 transition-colors duration-200">
                <i class="fa-solid fa-chevron-left"></i> Geri Dön
            </a>
        </div>

        <h1 class="text-3xl font-extrabold mb-6 text-center text-black">Yeni İzin Talebi Oluştur</h1>

        <form id="offdayForm" action="{{ route('offday.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            <div class="space-y-1">
                <label for="reason" class="block text-sm font-medium text-gray-700">Mazeret:</label>
                <input type="text" id="reason" name="reason" required
                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
            </div>

            <div id="datesContainer" class="space-y-4">
                <div class="space-y-1">
                    <label for="offday_date" class="block text-sm font-medium text-gray-700">İzin Günü:</label>
                    <input type="date" name="offday_dates[]" required
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
                </div>
            </div>

            <button type="button" id="addDateButton"
                class="w-full py-2 px-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                Tarih Ekle
            </button>

            <div class="space-y-1">
                <label for="attachments" class="block text-sm font-medium text-gray-700">Belge (.zip):</label>
                <input type="file" id="attachments" name="attachments"
                    class="block w-full text-sm text-gray-500 rounded-lg border border-gray-300 bg-white text-indigo-600 hover:bg-indigo-50 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            </div>

            <button type="submit"
                class="w-full py-3 px-4 bg-blue-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                İzin Talebi Oluştur
            </button>
        </form>
    </div>

    <!-- Pop-up Modal -->
    <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4 text-center text-green-600">Talebiniz Oluşturuldu</h2>
            <button id="closeModalButton"
                class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                Tamam
            </button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addDateButton = document.getElementById('addDateButton');
            const datesContainer = document.getElementById('datesContainer');
            const successModal = document.getElementById('successModal');
            const closeModalButton = document.getElementById('closeModalButton');
            const offdayForm = document.getElementById('offdayForm');

            // Function to show the success modal
            function showSuccessModal() {
                successModal.classList.remove('hidden');
            }

            // Function to hide the success modal
            function hideSuccessModal() {
                successModal.classList.add('hidden');
            }

            addDateButton.addEventListener('click', function() {
                const dateFieldGroup = document.createElement('div');
                dateFieldGroup.classList.add('space-y-1');

                const newDateInput = document.createElement('input');
                newDateInput.type = 'date';
                newDateInput.name = 'offday_dates[]';
                newDateInput.required = true;
                newDateInput.classList.add('block', 'w-full', 'border-gray-300', 'rounded-lg', 'shadow-sm',
                    'focus:ring-indigo-500', 'focus:border-indigo-500', 'p-2');

                dateFieldGroup.appendChild(newDateInput);

                datesContainer.appendChild(dateFieldGroup);
            });

            offdayForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(offdayForm);
                const dates = formData.getAll('offday_dates[]');
                let completedRequests = 0;

                dates.forEach(date => {
                    const individualFormData = new FormData(offdayForm);
                    individualFormData.set('offday_date', date);

                    fetch(offdayForm.action, {
                        method: 'POST',
                        body: individualFormData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')
                                .value
                        }
                    }).then(response => {
                        if (response.ok) {
                            completedRequests++;
                            if (completedRequests === dates.length) {
                                showSuccessModal();
                            }
                        } else {
                            console.error('Failed to create record for date:', date);
                        }
                    }).catch(error => {
                        console.error('Error submitting the form:', error);
                    });
                });
            });

            closeModalButton.addEventListener('click', hideSuccessModal);
        });
    </script>
@endsection
