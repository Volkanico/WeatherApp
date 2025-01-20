<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather in @if($city) {{ $city->name }} @else Palma de Mallorca @endif</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <header class="header">
            <h2 class="header__title">Weather in @if($city) {{ $city->name }} @else Palma de Mallorca @endif</h2>
        </header>

        <div class="content">
            <div class="weather-info">

                @if ($weatherData->isNotEmpty())
                    <div class="weather-info__card">
                        <h2 class="weather-info__temperature">{{ $weatherData->last()->temperature }}°C</h2>
                        <p class="weather-info__description">{{ $weatherData->last()->weather_description }}</p>
                        <p><strong>Wind Speed:</strong> {{ $weatherData->last()->windspeed }} km/h</p>
                        <p><strong>Wind Direction:</strong> {{ $weatherData->last()->winddirection }}°</p>
                        <p><strong>Time Recorded:</strong> {{ \Carbon\Carbon::parse($weatherData->last()->time)->format('H:i:s') }}</p>
                        <p><strong>Day/Night:</strong> {{ $weatherData->last()->is_day ? 'Day' : 'Night' }}</p>
                    </div>
                @else
                    <section class="no-data">
                        <p>No weather data available.</p>
                    </section>
                @endif

                <h3 class="weather-info__title">Weather Data</h3>
                <div class="weather-data-cards">
                    @foreach($weatherDataDetailed as $data)
                        <div class="weather-data-card">
                            <p class="weather-data-card__time">{{ \Carbon\Carbon::parse($data->created_at)->format('H:i') }}</p>
                            <p class="weather-data-card__temperature">{{ $data->temperature }}°C</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="graph-section">
                <canvas id="temperatureChart"></canvas>
                @if($city)
                <div class="city-info" style="text-align:center">
                    <p><strong>City:</strong> {{ $city->name }}</p>
                    <p><strong>Latitude:</strong> {{ $city->latitude }}</p>
                    <p><strong>Longitude:</strong> {{ $city->longitude }}</p>

                    <form action="{{ route('city.delete', ['id' => $city->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this city?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Delete City</button>
                    </form>
                </div>
            @endif
            </div>

            <button id="createCityBtn" class="create-city-btn">Create City</button>

            <div id="cityModal" class="modal">
                <div class="modal__overlay">
                    <form id="createCityForm" action="{{ route('city.create') }}" method="POST">
                        @csrf
                        <div class="modal__content">
                            <label for="cityName">City Name:</label>
                            <input type="text" id="cityName" name="name" required>
                            <span id="cityNameError" class="error-message"></span>

                            <label for="latitude">Latitude:</label>
                            <input type="text" id="latitude" name="latitude" required>
                            <span id="latitudeError" class="error-message"></span>

                            <label for="longitude">Longitude:</label>
                            <input type="text" id="longitude" name="longitude" required>
                            <span id="longitudeError" class="error-message"></span>

                            <button type="submit" class="submit-btn">Create City</button>
                            <button type="button" id="closeModalBtn" class="modal__close-btn">Close</button>
                        </div>
                    </form>
                </div>
            </div>

            @if ($cities->isEmpty())
                <p>No cities available</p>
            @else
                <form action="{{ route('weather.show') }}" method="GET" class="city-selector-form">
                    <label for="city" class="city-selector-form__label">Select City:</label>
                    <select name="city" id="city" class="city-selector-form__select">
                        @foreach ($cities as $city)
                            <option value="{{ $city->name }}" @if($city->id == $city->id) selected @endif>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="submit-btn">Get Weather</button>
                </form>
            @endif
        </div>
    </div>

<script>
    window.hourlyDataLabels = @json($hourlyData->pluck('hour'));
    window.hourlyDataTemperatures = @json($hourlyData->pluck('temperature'));
</script>

<script src="{{ asset('js/index.js') }}"></script>


</body>
</html>
