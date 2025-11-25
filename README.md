# Laravel E-commerce Platform

A comprehensive, modern e-commerce solution built with Laravel 12, featuring a complete admin panel, multiple payment gateways, and advanced e-commerce features.

## Features

### Core Features
- ✅ Complete Admin Panel with Dashboard
- ✅ Product Management (CRUD with images, categories, SEO)
- ✅ Category Management with Hierarchy
- ✅ Order Management System
- ✅ Customer Management
- ✅ Shopping Cart & Checkout
- ✅ Order Tracking

### Payment Gateways
- ✅ Stripe Integration
- ✅ PayPal Integration
- ✅ Razorpay Integration
- ✅ Cash on Delivery

### Advanced Features
- ✅ Product Reviews & Ratings
- ✅ Wishlist Functionality
- ✅ Coupon/Discount System
- ✅ Multiple Shipping Addresses
- ✅ Shipping Methods Management
- ✅ Email Notifications (Order confirmation, status updates, invoices)
- ✅ SEO Features (Meta tags, sitemap generation)
- ✅ Reports & Analytics
- ✅ Settings Management

### Security
- ✅ Role-based Access Control (Admin/Customer)
- ✅ CSRF Protection
- ✅ XSS Protection
- ✅ SQL Injection Prevention
- ✅ Secure Password Hashing

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18.x and NPM
- MySQL 5.7+ / PostgreSQL 10+ / SQLite
- Web Server (Apache/Nginx)

## Installation

See [INSTALLATION.md](INSTALLATION.md) for detailed installation instructions.

Quick start:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run build
```

## Documentation

- [Installation Guide](INSTALLATION.md)
- [User Documentation](DOCUMENTATION.md)
- [Changelog](CHANGELOG.md)

## Admin Access

After installation, create an admin user:

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
]);
```

Access admin panel at: `/admin`

## Configuration

### Payment Gateways

Configure in `.env`:

```env
STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_CLIENT_SECRET=your_paypal_client_secret
RAZORPAY_KEY=your_razorpay_key
RAZORPAY_SECRET=your_razorpay_secret
```

### Email

Configure mail settings in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

## Features Overview

### Admin Panel
- Dashboard with key metrics
- Product management with image upload
- Category management with hierarchy
- Order management and status updates
- Customer management
- Reports and analytics
- Settings configuration

### Frontend
- Product catalog with categories
- Product detail pages
- Shopping cart
- Checkout process
- Order history
- User profile management

## Support

For support, please contact through Codecanyon support system.

## License

See [LICENSE.txt](LICENSE.txt) for license information.

## Version

Current Version: 1.0.0

See [CHANGELOG.md](CHANGELOG.md) for version history.
