document.getElementById('createCityBtn').addEventListener('click', function() {
    document.getElementById('cityModal').classList.add('show');
});

document.getElementById('closeModalBtn').addEventListener('click', function() {
    document.getElementById('cityModal').classList.remove('show');
});

setTimeout(function() {
    location.reload();
}, 300000);

document.addEventListener('DOMContentLoaded', function () {
    const labels = [];
    for (let i = 0; i < 24; i++) {
        labels.push(i < 10 ? '0' + i : i.toString());
    }

    const hourlyData = window.hourlyDataLabels || [];
    const hourlyTemperatures = window.hourlyDataTemperatures || [];

    const temperatureData = new Array(24).fill(null);
    hourlyData.forEach((hour, index) => {
        const hourIndex = parseInt(hour.split(':')[0], 10);
        temperatureData[hourIndex] = hourlyTemperatures[index];
    });

    const ctx = document.getElementById('temperatureChart').getContext('2d');
    const temperatureChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Temperature (°C)',
                data: temperatureData,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Time (Hour)'
                    },
                    ticks: {
                        autoSkip: false,
                        maxRotation: 0,
                        minRotation: 0
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Temperature (°C)'
                    },
                    beginAtZero: false,
                    ticks: {
                        callback: function(value) {
                            return value.toFixed(1);
                        }
                    }
                }
            }
        }
    });
});


document.getElementById('createCityForm').addEventListener('submit', function(event) {
    document.getElementById('cityNameError').textContent = '';
    document.getElementById('latitudeError').textContent = '';
    document.getElementById('longitudeError').textContent = '';

    const cityName = document.getElementById('cityName').value;
    const latitude = document.getElementById('latitude').value;
    const longitude = document.getElementById('longitude').value;
    let isValid = true;

    if (!cityName || !latitude || !longitude) {
        if (!cityName) document.getElementById('cityNameError').textContent = 'City name is required.';
        if (!latitude) document.getElementById('latitudeError').textContent = 'Latitude is required.';
        if (!longitude) document.getElementById('longitudeError').textContent = 'Longitude is required.';
        isValid = false;
    }

    if (isNaN(latitude) || isNaN(longitude)) {
        if (!isNaN(cityName)) document.getElementById('cityNameError').textContent = 'City name must be a string of characters';
        if (isNaN(latitude)) document.getElementById('latitudeError').textContent = 'Latitude must be a number.';
        if (isNaN(longitude)) document.getElementById('longitudeError').textContent = 'Longitude must be a number.';
        isValid = false;
    }

    if (parseFloat(latitude) < -90 || parseFloat(latitude) > 90) {
        document.getElementById('latitudeError').textContent = 'Latitude must be between -90 and 90.';
        isValid = false;
    }

    if (parseFloat(longitude) < -180 || parseFloat(longitude) > 180) {
        document.getElementById('longitudeError').textContent = 'Longitude must be between -180 and 180.';
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault();
    }
});
