@extends('layout.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-wrap justify-center gap-8">
            <!-- Task Status Chart -->
            <div class="w-full md:w-1/2 lg:w-1/3 bg-white shadow-lg rounded-lg p-4">
                <h2 class="text-xl font-semibold mb-4 text-center">Task Durumu</h2>
                <canvas id="taskStatusChart"></canvas>
            </div>

            <!-- Offday Chart -->
            <div class="w-full md:w-1/2 lg:w-1/3 bg-white shadow-lg rounded-lg p-4">
                <h2 class="text-xl font-semibold mb-4 text-center">Aylık İzinler</h2>
                <canvas id="offdayChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js and Data Labels Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        // Task Status Chart
        $(document).ready(function() {
            $.ajax({
                url: '/tasks/status-counts',
                method: 'GET',
                success: function(data) {
                    var statuses = Object.keys(data);
                    var counts = Object.values(data);
                    var totalCount = counts.reduce((a, b) => a + b, 0);

                    var ctx = document.getElementById('taskStatusChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: statuses,
                            datasets: [{
                                label: 'Task Status',
                                data: counts,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.8)',
                                    'rgba(54, 162, 235, 0.8)',
                                    'rgba(255, 206, 86, 0.8)',
                                    'rgba(75, 192, 192, 0.8)',
                                    'rgba(153, 102, 255, 0.8)',
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            var percentage = (tooltipItem.raw / totalCount *
                                                100).toFixed(2);
                                            return `${tooltipItem.label}: ${tooltipItem.raw} (${percentage}%)`;
                                        }
                                    }
                                },
                                datalabels: {
                                    display: function(context) {
                                        return context.dataset.data[context.dataIndex] !==
                                        0;
                                    },
                                    formatter: (value, ctx) => {
                                        let sum = ctx.dataset.data.reduce((a, b) => a + b,
                                            0);
                                        let percentage = (value / sum * 100).toFixed(2);
                                        return percentage + '%';
                                    },
                                    color: '#fff',
                                }
                            }
                        },
                        plugins: [{
                            beforeDraw: function(chart) {
                                var width = chart.width,
                                    height = chart.height,
                                    ctx = chart.ctx;
                                ctx.restore();
                                var fontSize = (height / 160).toFixed(2);
                                ctx.font = fontSize + "em sans-serif";
                                ctx.textBaseline = "middle";
                                var text = totalCount.toString(),
                                    textX = Math.round((width - ctx.measureText(
                                        text).width) / 2),
                                    textY = height / 2;
                                ctx.fillText(text, textX, textY);
                                ctx.save();
                            }
                        }]
                    });
                },
                error: function(error) {
                    console.log('Error fetching status counts:', error);
                }
            });
        });

        // Offday Chart
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/offday/monthly-data')
                .then(response => response.json())
                .then(data => {
                    const months = data.map(item => item.month);
                    const counts = data.map(item => item.count);

                    const ctx = document.getElementById('offdayChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: months.map(month => `Month ${month}`),
                            datasets: [{
                                label: 'Offdays Count',
                                data: counts,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        });
    </script>
@endsection
