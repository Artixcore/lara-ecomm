# User Documentation

## Table of Contents

1. [Getting Started](#getting-started)
2. [Admin Panel](#admin-panel)
3. [Product Management](#product-management)
4. [Order Management](#order-management)
5. [Customer Management](#customer-management)
6. [Settings](#settings)
7. [Reports & Analytics](#reports--analytics)

## Getting Started

After installation, access the admin panel at `/admin` using your admin credentials.

## Admin Panel

### Dashboard

The dashboard provides an overview of:
- Total sales
- Total orders
- Total products
- Total customers
- Recent orders
- Quick stats

### Navigation

The admin sidebar provides access to:
- Dashboard
- Products
- Categories
- Orders
- Customers
- Settings
- Reports

## Product Management

### Adding Products

1. Navigate to **Admin > Products**
2. Click **Add New Product**
3. Fill in product details:
   - Name
   - Description
   - Price
   - Stock quantity
   - Product image
   - Category
   - Status (Active/Inactive)
   - SEO fields (Meta title, description, keywords)
4. Click **Create Product**

### Editing Products

1. Navigate to **Admin > Products**
2. Click **Edit** on the product you want to modify
3. Update the fields
4. Click **Update Product**

### Deleting Products

1. Navigate to **Admin > Products**
2. Click **Delete** on the product
3. Confirm deletion

## Category Management

### Creating Categories

1. Navigate to **Admin > Categories**
2. Click **Add New Category**
3. Fill in:
   - Category name
   - Description
   - Parent category (for subcategories)
   - Sort order
   - Active status
4. Click **Create Category**

## Order Management

### Viewing Orders

1. Navigate to **Admin > Orders**
2. View all orders with status, customer, and amount
3. Click **View** to see order details

### Updating Order Status

1. Open an order
2. Select new status from dropdown
3. Click **Update Status**
4. Customer will receive email notification

### Order Statuses

- **Pending**: Order placed, awaiting processing
- **Processing**: Order being prepared
- **Shipped**: Order shipped to customer
- **Delivered**: Order delivered successfully
- **Cancelled**: Order cancelled

## Customer Management

### Viewing Customers

1. Navigate to **Admin > Customers**
2. View customer list with order counts
3. Click **View** to see customer details and order history

## Settings

### General Settings

Configure:
- Site name
- Site email
- Site phone
- Site address

### Currency Settings

Set:
- Currency code (USD, EUR, etc.)
- Currency symbol ($, €, etc.)
- Tax rate (percentage)

## Reports & Analytics

### Sales Reports

1. Navigate to **Admin > Reports**
2. Select time period (Daily, Weekly, Monthly, Yearly)
3. View sales trends and statistics

### Product Reports

View top-selling products and product performance metrics.

## Frontend Features

### Shopping Cart

- Add products to cart
- Update quantities
- Remove items
- View cart total

### Checkout Process

1. Review cart items
2. Enter shipping address
3. Select payment method
4. Complete payment
5. Receive order confirmation email

### Order Tracking

Customers can view their orders in their account dashboard and track order status.

## Payment Methods

Supported payment methods:
- Stripe
- PayPal
- Razorpay
- Cash on Delivery

Configure payment gateways in Admin > Settings.

## Email Notifications

Automatic emails sent for:
- Order confirmation
- Order status updates
- Invoice generation

Configure email settings in `.env` file.

## SEO Features

- SEO-friendly URLs
- Meta tags per product
- Sitemap generation
- Schema.org markup

Generate sitemap: `php artisan sitemap:generate`

## Security

- CSRF protection
- XSS protection
- SQL injection prevention
- Role-based access control
- Secure password hashing

## Support

For technical support, contact through Codecanyon support system.

