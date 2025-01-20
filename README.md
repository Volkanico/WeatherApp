# Weather App - Laravel Project

## Overview

This project is a weather application built with Laravel, which fetches real-time weather data from the Open-Meteo API. It stores the temperature data on an hourly basis in a database and displays it in a line chart. The app provides a seamless way to visualize temperature trends over time for various cities.

---

## Features

- **Real-time Weather Data**: The application fetches live temperature data every minute, which is then processed and stored in the database.
- **Hourly Temperature Display**: Although the API is called every minute, the backend processes and displays the data in hourly format.
- **Cities Management**: Predefined cities are seeded into the database for testing, and new cities can be added manually.
- **Weather Data Chart**: The app displays a beautiful line chart showing temperature data over time.
- **Scheduled Tasks**: Laravel’s task scheduling is used to periodically fetch weather data.

---

## Requirements

- PHP 8.0 or higher
- Composer
- Laravel 8 or higher
- MySQL or other compatible databases

---

## Installation

### Step 1: Clone the Repository

Clone the project repository to your local machine:

git clone https://github.com/yourusername/weatherapp.git
cd weatherapp


### Step 2: Install Dependencies

Install the required dependencies using Composer:

composer install

### Step 3: Configure the Environment

Copy the .env.example file to .env and configure your environment settings (e.g., database connection):

cp .env.example .env

Make sure your .env file has the correct database credentials for MySQL (or the database you prefer).

### Step 4: Generate Application Key

To generate the Laravel application encryption key, run:

php artisan key:generate

This will set the APP_KEY in your .env file and ensure that Laravel can securely encrypt and store data.

### Step 5: Set Up the Database

Create a database named weatherapp:

CREATE DATABASE weatherapp;

### Step 6: Run Migrations and Seeders

Run the database migrations and seeders to set up the schema and populate it with predefined cities:

php artisan migrate
php artisan db:seed

### Step 7: Start the Laravel Development Server

Start the Laravel development server:

php artisan serve

The application will be accessible at http://localhost:8000.

### Step 8: Run Scheduled Tasks

To start fetching the weather data periodically, run the following command:

php artisan schedule:work

This will run the scheduled tasks that fetch the weather data every minute (or every hour, if you prefer — see below).


### Customization (Optional)
If you'd prefer the API to be called once every hour instead of every minute, you can adjust the task interval by modifying the cron definition:

Open the bootstrap/app.php file.

Locate the line (24L): $schedule->command('weather:fetch')->everyMinute();
Change it to: $schedule->command('weather:fetch')->hourly();

This will change the frequency of the API calls to once every hour.


### How to Use
Once the server is running, visit http://localhost:8000 in your browser.
Select the desired city from the dropdown menu.
The temperature data for the selected city will be displayed in a graph showing the temperature over time.
You can also add new cities via the modal and view their weather data.

### Conclusion
This project was built with Laravel and makes use of the Open-Meteo API to deliver reliable and real-time temperature information. Feel free to reach out for any further questions or if you need additional features added!
