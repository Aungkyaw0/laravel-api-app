# Meal On Wheels

<p align="center">
  <!-- You can replace this with your project logo if you have one -->
  <img src="resources\views\img\logo.png" alt="Project Logo" width="200"/>
</p>

<p align="center">
  <a href="#about">About</a> •
  <a href="#features">Features</a> •
  <a href="#getting-started">Getting Started</a> •
  <a href="#installation">Installation</a> •
  <a href="#tech-stack">Tech Stack</a> •
  <a href="#environment-variables">Environment Variables</a> •
  <a href="#api-documentation">API Documentation</a>
</p>

## About

MerryMeal is a charitable organization dedicated to providing meal services to vulnerable adults who cannot cook for themselves due to age, illness, or disability. The project aims to digitize and streamline their operations through a comprehensive web-based platform.

## Features

- 🔒 Registeration, Login, Logout Module
- 🚀 Member Module - Request Dietary Update, Request Order, View Order History
- 💾 Caregiver Module - View Members, Create Menu, Create & Assign Meal Plan, Accept Dietary Request, View Dietary Request History
- ✨ Partner Module - Create Food Service, Add Meal, Accept Order, View Order History
- 📱 Volunteer Moduel - Update Availablity, View Delivery, Accept Delivery, View Completed Delivery
- 🔒 Admin Module - Manage Users, View All Meal Plans, Dietary Requests, Orders, Activate Food Service

## Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/PostgreSQL

### Installation

1. Clone the repository

```bash
git clone https://github.com/Aungkyaw0/laravel-api-app.git
```

2. Install PHP dependencies

```bash
composer install
```

3. Install NPM dependencies

```bash
npm install
```

4. Create Tables and Seed Data

```bash
php artisan migrate
```

5. Create Admin Data

```bash
php artisan db:seed --class=AdminUserSeeder
```

6. Create environment file

```bash
cp .env.example .env
```

7. Generate application key

```bash
php artisan key:generate
```

8. Run

```bash
php artisan serve
```

## Tech Stack

- PHP
- Laravel
- MySQL/PostgreSQL
- Node.js & NPM
- Blade Template 

## Environment Variables

- `APP_NAME`
- `APP_ENV`
- `APP_KEY`
- `DB_CONNECTION`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `CACHE_DRIVER`
- `SESSION_DRIVER`
- `QUEUE_CONNECTION`
- `REDIS_HOST`
- `REDIS_PASSWORD`
- `REDIS_PORT`
- `MAIL_DRIVER`
- `MAIL_HOST`
- `MAIL_PORT`
- `MAIL_USERNAME`
- `MAIL_PASSWORD`
- `MAIL_ENCRYPTION`
- `AWS_ACCESS_KEY_ID`
- `AWS_SECRET_ACCESS_KEY`
- `AWS_DEFAULT_REGION`
- `AWS_BUCKET`
- `AWS_URL`
- `PUSHER_APP_ID`
- `PUSHER_APP_KEY`
- `PUSHER_APP_SECRET`
- `PUSHER_APP_CLUSTER`
- `MIX_PUSHER_APP_ID`
- `MIX_PUSHER_APP_KEY`
- `MIX_PUSHER_APP_SECRET`
- `MIX_PUSHER_APP_CLUSTER`



## Contributing

Contributions are always welcome!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request
## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
