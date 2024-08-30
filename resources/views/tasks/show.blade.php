@extends(auth()->user()->is_admin ? 'layout.app' : 'userLayout.app')



@section('content')
    <div class="container mx-auto mt-48 flex flex-col md:flex-row md:space-x-8 p-4">
        <div
            class="shadow-lg rounded-lg p-8 mb-6 md:mb-0 hover:shadow-xl transition-shadow duration-300 flex-1 ml-0 md:ml-64 border-gray-300 border-2 bg-white">
            <div class="mb-6">

                @if (auth()->user()->is_admin)
                    <a href="{{ route('mission.index') }}"
                        class="text-sky-500 hover:text-blue-800 transition-colors duration-200 flex items-center">
                        <i class="fa-solid fa-chevron-left mr-2"></i> Geri Dön
                    </a>
                @else
                    <a href="{{ route('mission.indexUser') }}"
                        class="text-sky-500 hover:text-blue-800 transition-colors duration-200 flex items-center">
                        <i class="fa-solid fa-chevron-left mr-2"></i> Geri Dön
                    </a>
                @endif






            </div>
            <div class="space-y-4">
                <p class="text-gray-700"><strong>Görev Başlığı:</strong> {{ $task->title }}</p>
                <p class="text-gray-700"><strong>Görev İçeriği:</strong> {{ $task->description }}</p>
                <p class="text-gray-700"><strong>Başlangıç Tarihi:</strong> {{ $task->start_date }}</p>
                <p class="text-gray-700"><strong>Bitiş Tarihi:</strong> {{ $task->due_date }}</p>
                <p class="text-gray-700"><strong>Durum:</strong> {{ $task->status }}</p>
                <p class="text-gray-700"><strong>Atanan Kişi:</strong> {{ $task->assignedUser->name ?? 'Kişi yok' }}</p>
                <p class="text-gray-700"><strong>Proje:</strong> {{ $task->assignedProject->name ?? 'Proje yok' }}</p>
                <p class="text-gray-700"><strong>Ekler:</strong>
                    @if ($task->attachments)
                        <a href="{{ route('attachments.download', ['filename' => basename($task->attachments)]) }}"
                            class="fa-solid fa-paperclip cursor-pointer text-blue-500 hover:text-blue-800 transition-colors duration-200"
                            title="İndir"></a>
                    @endif
                </p>
            </div>

            @if (auth()->user()->is_admin)
                <div class="mt-4 flex justify-between">
                    <a href="{{ route('tasks.edit', $task->id) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">Düzenle</a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                        onsubmit="return confirm('Bu görevi silmek istediğinize emin misiniz?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">Sil</button>
                    </form>
                </div>
            @endif
        </div>

        <div
            class=" shadow-lg rounded-lg p-8 hover:shadow-xl transition-shadow duration-300 flex-1 border-gray-300 border-2 bg-white">
            <div class="calendar p-4 rounded-lg">
                <div class="flex items-center justify-between mb-6 p-4 bg-[#F1F5F9] rounded-lg shadow-sm">
                    <button id="prev-month"
                        class="flex items-center bg-[#F1F5F9] hover:bg-gray-300 p-2 rounded-lg transition duration-200 ">
                        <i class="fa-solid fa-calendar-minus text-xl mr-2 text-red-700"></i>
                        <span class="hidden md:inline">Önceki</span>
                    </button>
                    <span id="current-month" class="text-2xl font-bold text-gray-900"></span>
                    <button id="next-month"
                        class="flex items-center bg-[#F1F5F9] text-gray-800 hover:bg-gray-300 p-2 rounded-lg transition duration-200">
                        <span class="hidden md:inline">Sonraki</span>
                        <i class="fa-solid fa-calendar-plus text-xl ml-2 text-green-700"></i>
                    </button>
                </div>

                <div class="grid grid-cols-7 gap-1 text-center text-gray-600 font-medium">
                    <div>Pzt</div>
                    <div>Sal</div>
                    <div>Çar</div>
                    <div>Per</div>
                    <div>Cum</div>
                    <div>Cmt</div>
                    <div>Paz</div>
                </div>

                <div id="calendar-days" class="grid grid-cols-7 gap-1 mt-2 text-center text-gray-700">
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDate = new Date("{{ $task->start_date }}");
            const endDate = new Date("{{ $task->due_date }}");
            let currentMonth = startDate.getMonth();
            let currentYear = startDate.getFullYear();

            const publicHolidays = [
                // 2024
                "01/01/2024", "04/23/2024", "05/01/2024", "05/19/2024", "03/28/2024", "03/29/2024",
                "03/30/2024", "03/31/2024", "08/30/2024", "10/04/2024", "10/05/2024", "10/06/2024",
                "10/07/2024", "10/08/2024", "10/29/2024",
                // 2025
                "01/01/2025", "04/23/2025", "05/01/2025", "05/19/2025", "03/17/2025", "03/18/2025",
                "03/19/2025", "03/20/2025", "08/30/2025", "06/15/2025", "06/16/2025", "06/17/2025",
                "06/18/2025", "10/29/2025",
                // 2026
                "01/01/2026", "04/23/2026", "05/01/2026", "05/19/2026", "03/07/2026", "03/08/2026",
                "03/09/2026", "03/10/2026", "08/30/2026", "06/05/2026", "06/06/2026", "06/07/2026",
                "06/08/2026", "10/29/2026",
                // 2027
                "01/01/2027", "04/23/2027", "05/01/2027", "05/19/2027", "02/27/2027", "02/28/2027",
                "03/01/2027", "03/02/2027", "08/30/2027", "05/27/2027", "05/28/2027", "05/29/2027",
                "05/30/2027", "10/29/2027",
                // 2028
                "01/01/2028", "04/23/2028", "05/01/2028", "05/19/2028", "01/16/2028", "01/17/2028",
                "01/18/2028", "01/19/2028", "08/30/2028", "05/15/2028", "05/16/2028", "05/17/2028",
                "05/18/2028", "10/29/2028",
                // 2029
                "01/01/2029", "04/23/2029", "05/01/2029", "05/19/2029", "01/06/2029", "01/07/2029",
                "01/08/2029", "01/09/2029", "08/30/2029", "05/02/2029", "05/03/2029", "05/04/2029",
                "05/05/2029", "10/29/2029",
                // 2030
                "01/01/2030", "04/23/2030", "05/01/2030", "05/19/2030", "01/26/2030", "01/27/2030",
                "01/28/2030", "01/29/2030", "08/30/2030", "05/25/2030", "05/26/2030", "05/27/2030",
                "05/28/2030", "10/29/2030",
                // 2031
                "01/01/2031", "04/23/2031", "05/01/2031", "05/19/2031", "01/15/2031", "01/16/2031",
                "01/17/2031", "01/18/2031", "08/30/2031", "05/08/2031", "05/09/2031", "05/10/2031",
                "05/11/2031", "10/29/2031",
                // 2032
                "01/01/2032", "04/23/2032", "05/01/2032", "05/19/2032", "01/05/2032", "01/06/2032",
                "01/07/2032", "01/08/2032", "08/30/2032", "05/22/2032", "05/23/2032", "05/24/2032",
                "05/25/2032", "10/29/2032",
                // 2033
                "01/01/2033", "04/23/2033", "05/01/2033", "05/19/2033", "01/24/2033", "01/25/2033",
                "01/26/2033", "01/27/2033", "08/30/2033", "05/07/2033", "05/08/2033", "05/09/2033",
                "05/10/2033", "10/29/2033",
                // 2034
                "01/01/2034", "04/23/2034", "05/01/2034", "05/19/2034", "01/16/2034", "01/17/2034",
                "01/18/2034", "01/19/2034", "08/30/2034", "05/25/2034", "05/26/2034", "05/27/2034",
                "05/28/2034", "10/29/2034"
            ];

            function isWeekend(date) {
                return date.getDay() === 0 || date.getDay() === 6; 
            }

            function isPublicHoliday(date) {
                const formattedDate =
                    `${String(date.getMonth() + 1).padStart(2, '0')}/${String(date.getDate()).padStart(2, '0')}/${date.getFullYear()}`;
                return publicHolidays.includes(formattedDate);
            }

            function updateCalendar(month, year) {
                const calendarDays = document.getElementById('calendar-days');
                const currentMonthEl = document.getElementById('current-month');
                calendarDays.innerHTML = '';

                const monthNames = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos",
                    "Eylül", "Ekim", "Kasım", "Aralık"
                ];
                currentMonthEl.textContent = `${monthNames[month]} ${year}`;

                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                const startDayOffset = (firstDay === 0) ? 6 : firstDay - 1;

                for (let i = 0; i < startDayOffset; i++) {
                    const emptyDiv = document.createElement('div');
                    calendarDays.appendChild(emptyDiv);
                }

                for (let i = 1; i <= daysInMonth; i++) {
                    const dayDiv = document.createElement('div');
                    dayDiv.textContent = i;
                    dayDiv.classList.add('py-2');
                    const currentDate = new Date(year, month, i);

                    if (isWeekend(currentDate) || isPublicHoliday(currentDate)) {
                        dayDiv.classList.add('text-gray-400');
                    } else if (currentDate.toDateString() === startDate.toDateString()) {
                        dayDiv.classList.add('bg-green-500', 'text-white', 'rounded');
                    } else if (currentDate.toDateString() === endDate.toDateString()) {
                        dayDiv.classList.add('bg-red-500', 'text-white', 'rounded');
                    } else if (currentDate > startDate && currentDate < endDate) {
                        dayDiv.classList.add('bg-orange-500', 'text-white', 'rounded');
                    }

                    calendarDays.appendChild(dayDiv);
                }
            }

            document.getElementById('prev-month').addEventListener('click', function() {
                if (currentMonth === 0) {
                    currentMonth = 11;
                    currentYear -= 1;
                } else {
                    currentMonth -= 1;
                }
                updateCalendar(currentMonth, currentYear);
            });

            document.getElementById('next-month').addEventListener('click', function() {
                if (currentMonth === 11) {
                    currentMonth = 0;
                    currentYear += 1;
                } else {
                    currentMonth += 1;
                }
                updateCalendar(currentMonth, currentYear);
            });

            updateCalendar(currentMonth, currentYear);
        });
    </script>
@endsection
