# Installation Guide

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18.x and NPM
- MySQL 5.7+ or PostgreSQL 10+ or SQLite
- Web Server (Apache/Nginx)

## Installation Steps

### 1. Download and Extract

Download the script from Codecanyon and extract it to your web server directory.

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Configuration

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 4. Database Configuration

Edit the `.env` file and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Seed Database (Optional)

```bash
php artisan db:seed
```

### 7. Create Storage Link

```bash
php artisan storage:link
```

### 8. Build Assets

```bash
npm run build
```

### 9. Set Permissions

Ensure the following directories are writable:

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 10. Create Admin User

Run the following command to create an admin user:

```bash
php artisan tinker
```

Then execute:

```php
$user = \App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
]);
```

### 11. Configure Web Server

#### Apache

Ensure mod_rewrite is enabled and add the following to your `.htaccess`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

#### Nginx

```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### 12. Configure Payment Gateways

Edit `.env` and add your payment gateway credentials:

```env
# Stripe
STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret

# PayPal
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_CLIENT_SECRET=your_paypal_client_secret
PAYPAL_MODE=sandbox

# Razorpay
RAZORPAY_KEY=your_razorpay_key
RAZORPAY_SECRET=your_razorpay_secret
```

### 13. Configure Email

Edit `.env` and configure your mail settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 14. Queue Configuration (Optional)

For better performance, set up queue workers:

```bash
php artisan queue:work
```

Or configure supervisor for automatic queue processing.

### 15. Generate Sitemap

```bash
php artisan sitemap:generate
```

## Post-Installation

1. Log in to the admin panel at `/admin`
2. Configure your store settings in Admin > Settings
3. Add your products, categories, and shipping methods
4. Configure payment gateways
5. Test the checkout process

## Troubleshooting

### Permission Errors

If you encounter permission errors:

```bash
chmod -R 775 storage bootstrap/cache
```

### 500 Error

- Check `.env` file configuration
- Ensure `APP_KEY` is set
- Check web server error logs
- Verify file permissions

### Database Connection Error

- Verify database credentials in `.env`
- Ensure database exists
- Check database server is running

## Support

For support, please contact us through Codecanyon support system.

