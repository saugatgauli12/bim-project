
# DiwakarSewa - Smartphone E-Commerce System

## Overview
DiwakarSewa is a complete smartphone e-commerce web application built with PHP (Core PHP), MySQL, and Tailwind CSS for styling.

## Features
- User registration, login, and session management
- Browse, add, and manage products
- Shopping cart and checkout with order placement
- Order status tracking and PDF invoice generation
- Admin panel for product, customer, and order management
- Responsive design with Tailwind CSS
- Charts for monthly revenue and order distribution (admin dashboard)

## Setup Instructions

1. Install [XAMPP](https://www.apachefriends.org/index.html) or similar PHP+MySQL stack.
2. Place the `DiwakarSewa` folder in your web server's root (e.g., `htdocs` for XAMPP).
3. Import the database:
   - Create a MySQL database named `diwakarsewa`.
   - Import `database.sql` file provided.
4. Configure database credentials in `includes/db.php` if needed.
5. Access the app via browser:
   - User frontend: `http://localhost/DiwakarSewa/pages/home.php`
   - Admin panel: `http://localhost/DiwakarSewa/admin/dashboard.php` (login as admin)
6. Default admin credentials:  
   - Email: admin@example.com  
   - Password: admin123

## Dependencies
- PHP 7+
- MySQL
- Tailwind CSS (CDN)
- FPDF library (included)
- Chart.js (CDN for admin charts)

## Notes
- For PDF invoices, FPDF is included in `/actions/fpdf.php`.
- Image upload folder is `/assets/images/`.
- Sessions handle user login states.

---

Enjoy your DiwakarSewa store!
