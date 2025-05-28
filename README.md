# Billing System API – Laravel

A simple yet scalable billing system built with Laravel, designed to handle customers and invoices through a RESTful API.

> 🚧 This project is currently under development. Automated testing and additional features will be added in upcoming updates.

---

## 📦 Features

- User authentication using Laravel Sanctum
- Manage Customers (CRUD)
- Manage Invoices (CRUD)
- Invoice totals and due dates
- Basic validation and error handling
- API response formatting (JSON)

---

## 🛠️ Tech Stack

- PHP 8.x
- Laravel 11.x
- MySQL
- Laravel Sanctum (for authentication)

---

## ⚙️ Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/billing-system-api.git
   cd billing-system-api

2. Install dependencies:
    ```bash
    composer install
     
3. Create a copy of .env:
    ```bash
    cp .env.example .env
    
4. Set your DB credentials in .env, then run:
    ```bash
    php artisan key:generate
    php artisan migrate

5. (Optional) Seed the database:
   ```bash
   php artisan db:seed

6. Serve the app:
    ```bash
    php artisan serve
    
## 🔐 Authentication
Authentication is handled via Laravel Sanctum. After registering or logging in, use the returned token in the Authorization header:

    ```bash
    Authorization: Bearer YOUR_TOKEN


## 📮 Example Endpoints

| Method | Endpoint               | Description          |
|--------|------------------------|----------------------|
| GET    | /api/v1/customers       | List all customers   |
| POST   | /api/v1/customers       | Create new customer  |
| PUT    | /api/v1/customers/{id}  | Update a customer    |
| DELETE | /api/v1/customers/{id}  | Delete a customer    |
| GET    | /api/v1/invoices        | List all invoices    |
| POST   | /api/v1/invoices        | Create new invoice   |
| PUT    | /api/v1/invoices/{id}   | Update an invoice    |
| DELETE | /api/v1/invoices/{id}   | Delete an invoice    |


✅ To Do
 - Add Feature & Unit Testing
 - Improve error handling
 - Add invoice PDF export


📫 Contact
Feel free to reach out if you'd like to know more or suggest improvements.

🧪 Automated testing will be added in the next phase.
