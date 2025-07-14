<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $crypto->name }}</title>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- TailwindCSS с поддержкой dark mode -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {}
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="dark bg-gray-900 text-gray-200">
<div class="max-w-3xl mx-auto py-8 px-4">
    <a href="/" class="text-blue-400 hover:underline text-sm">&larr; Назад</a>
    <h1 class="text-3xl font-bold mt-2 text-white">{{ $crypto->name }} ({{ strtoupper($crypto->symbol) }})</h1>

    <div class="mt-4 text-lg space-y-2">
        <p><strong>Цена:</strong> ${{ number_format($crypto->price_usd, 2) }}</p>
        <p>
            <strong>Изм. за 24ч:</strong>
            <span class="{{ $crypto->change_24h >= 0 ? 'text-green-400' : 'text-red-400' }}">
                {{ number_format($crypto->change_24h, 2) }}%
            </span>
        </p>
        <p><strong>Капитализация:</strong> ${{ number_format($crypto->market_cap) }}</p>
        <p><strong>Объём торгов:</strong> ${{ number_format($crypto->volume_24h) }}</p>
    </div>

    <div class="mt-6">
        <h2 class="text-xl font-semibold mb-2 text-white">График за 7 дней</h2>
        <div class="h-64">
            <canvas id="chart" class="w-full h-full"></canvas>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('chart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [...Array({{ count($crypto->sparkline) }})].map((_, i) => i + 1),
            datasets: [{
                label: '{{ $crypto->name }}',
                data: @json($crypto->sparkline),
                borderColor: '{{ $crypto->change_24h >= 0 ? "#22c55e" : "#ef4444" }}',
                borderWidth: 2,
                pointRadius: 0,
                tension: 0.3,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    ticks: { color: '#e5e7eb' }, // text-gray-200
                    grid: { color: '#374151' }   // bg-gray-700
                },
                y: {
                    ticks: {
                        color: '#e5e7eb',
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    },
                    grid: { color: '#374151' }
                }
            },
            plugins: {
                legend: {
                    labels: { color: '#f3f4f6' }
                },
                tooltip: {
                    backgroundColor: '#1f2937', // bg-gray-800
                    titleColor: '#f9fafb',
                    bodyColor: '#f3f4f6'
                }
            }
        }
    });
</script>
</body>
</html>
