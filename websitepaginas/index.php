<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temperatuur Grafiek</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3"></script> <!-- De juiste adapter -->
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #333;
        }
        canvas {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }
        .button-container {
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Temperatuur Grafiek</h1>
    <canvas id="temperatureChart"></canvas>
    <div class="button-container">
        <a href="index.php" class="button">Terug naar Homepagina</a>
    </div>
    <script>
        const ctx = document.getElementById('temperatureChart').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [], // x-as labels
                datasets: [{
                    label: 'Temperatuur',
                    data: [], // y-as gegevens
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'minute',
                            tooltipFormat: 'll HH:mm',
                            displayFormats: {
                                minute: 'HH:mm'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Tijd'
                        },
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 10
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Temperatuur (°C)'
                        }
                    }
                }
            }
        });

        async function fetchTemperatureData() {
            const response = await fetch('api.php?get=latest');
            const data = await response.json();
            return data;
        }

        async function updateChart() {
            const data = await fetchTemperatureData();
            const labels = data.map(d => new Date(d.timestamp));
            const temperatures = data.map(d => d.temperature);

            // Update chart data
            chart.data.labels = labels;
            chart.data.datasets[0].data = temperatures;

            // Ensure the latest data is visible and maintain the last 20 points
            if (chart.data.labels.length > 20) {
                chart.data.labels = chart.data.labels.slice(-20);
                chart.data.datasets[0].data = chart.data.datasets[0].data.slice(-20);
            }

            chart.update();
        }

        updateChart(); // Initial load
        setInterval(updateChart, 5000); // Update de grafiek elke 5 seconden
    </script>
</body>
</html>
root@server-of-runar:~# cat /var/www/html/index.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #333;
        }
        .button-container {
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Welkom op de Homepagina</h1>
    <div class="button-container">
        <a href="temperatures.html" class="button">Bekijk de temperatuurgegevens</a>
        <a href="about_us.html" class="button">About Us</a>
        <a href="chart.html" class="button">Bekijk Temperatuur Grafiek</a> <!-- Zorg ervoor dat dit naar chart.html verwijst -->
    </div>
</body>
</html>