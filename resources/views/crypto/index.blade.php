<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Top 50 Cryptos</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center text-white">Топ-50 криптовалют</h1>
    <div class="overflow-x-auto bg-gray-800 rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-700 text-sm text-center">
            <thead class="bg-gray-700 text-gray-200">
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Название</th>
                <th class="px-4 py-3">Тикер</th>
                <th class="px-4 py-3">Цена</th>
                <th class="px-4 py-3">24ч</th>
                <th class="px-4 py-3">Капитализация</th>
                <th class="px-4 py-3">Объём</th>
                <th class="px-4 py-3">График</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
            @foreach($cryptos as $index => $crypto)
                <tr class="hover:bg-gray-700 transition">
                    <td class="py-2">{{ $index + 1 }}</td>
                    <td class="py-2 font-medium">
                        <a href="{{ route('crypto.show', ['symbol' => strtolower($crypto->symbol)]) }}" class="text-blue-400 hover:underline">
                            {{ $crypto->name }}
                        </a>
                    </td>
                    <td class="py-2 uppercase">{{ $crypto->symbol }}</td>
                    <td class="py-2">${{ number_format($crypto->price_usd, 2) }}</td>
                    <td class="py-2 {{ $crypto->change_24h >= 0 ? 'text-green-400' : 'text-red-400' }}">
                        {{ number_format($crypto->change_24h, 2) }}%
                    </td>
                    <td class="py-2">${{ number_format($crypto->market_cap) }}</td>
                    <td class="py-2">${{ number_format($crypto->volume_24h) }}</td>
                    <td class="py-2">
                        <canvas id="chart-{{ $index }}" width="100" height="30"></canvas>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    @foreach($cryptos as $index => $crypto)
    @if (!empty($crypto->sparkline))
    const ctx{{ $index }} = document.getElementById('chart-{{ $index }}').getContext('2d');
    new Chart(ctx{{ $index }}, {
        type: 'line',
        data: {
            labels: [...Array({{ count($crypto->sparkline) }})].map((_, i) => i + 1),
            datasets: [{
                data: @json($crypto->sparkline),
                borderColor: '{{ $crypto->change_24h >= 0 ? "#22c55e" : "#ef4444" }}',
                borderWidth: 2,
                pointRadius: 0,
                tension: 0.4
            }]
        },
        options: {
            responsive: false,
            scales: { x: { display: false }, y: { display: false } },
            plugins: { tooltip: { enabled: false }, legend: { display: false } }
        }
    });
    @endif
    @endforeach
</script>
</body>
</html>
