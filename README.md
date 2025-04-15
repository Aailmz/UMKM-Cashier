# UMKM-Cashier Project Setup

## Clone and Installation
```
git clone https://github.com/Aailmz/UMKM-Cashier.git
cd UMKM-Cashier
composer install
cp .env.example .env
php artisan key:generate
```

## Database Configuration
Edit your `.env` file with database settings:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## SMTP Configuration
Add these settings to your `.env` file:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Run Migrations
```
php artisan migrate
php artisan db:seed
```

## Permissions (Linux/Mac)
```
chmod -R 777 storage bootstrap/cache
```

## Run Development Server
```
php artisan serve
```

## Default Login Credentials
```
Admin:
Username: admin
Password: 12345678

Store (Activate first):
Username: Mirza
Password: 12345678
```
