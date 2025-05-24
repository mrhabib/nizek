
# 🚀 Laravel Stock App

A Laravel 11 application that handles stock price tracking with scalable queue workers and custom import functionality.

---

## 🔥 Features
- Stock price aggregation with percentage change calculations
- Scalable queue management with **Supervisor**
- File uploads for stock imports
- RESTful APIs for querying stock price changes
- Supports **Laravel Sail** and **local (non-Sail)** setups

---

## ⚙️ Requirements
- PHP 8.1+
- Composer
- Docker & Docker Compose (for Sail)
- Redis (for queues and caching)

---

## 🚀 Setup Instructions

---

### 🐳 **Run with Laravel Sail**

1️⃣ Install dependencies:
```bash
composer install
```

2️⃣ Start the app using Sail:
```bash
./vendor/bin/sail up -d
```

3️⃣ Build containers (if needed):
```bash
./vendor/bin/sail build
```

4️⃣ Run migrations:
```bash
./vendor/bin/sail artisan migrate 
```

5️⃣ Run queues with **Supervisor** (configured in Docker):
```bash
# Sail will automatically start Supervisor and manage the workers for both queues (default & stock-aggregate)
./vendor/bin/sail logs -f laravel.test
```

6️⃣ Access the app:
- API: `http://localhost/api`
- Horizon (if installed): `http://localhost/horizon`

---

### 💻 **Run Locally (Without Sail)**

1️⃣ Install dependencies:
```bash
composer install
```

2️⃣ Copy `.env` and configure your database and Redis settings.

3️⃣ Run migrations:
```bash
php artisan migrate
```

4️⃣ Start the Laravel development server:
```bash
php artisan serve
```

5️⃣ Run queue workers (separate terminal tabs/windows):
```bash
php artisan queue:work --queue=default
php artisan queue:work --queue=stock-aggregate
```

6️⃣ (Optional) Run **Supervisor** locally:
- Install Supervisor (`sudo apt install supervisor`)
- Configure Supervisor to manage both queues (refer to `/docker/supervisor` files)
- Start Supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-queue-default:*
sudo supervisorctl start laravel-queue-stock-aggregate:*
```

---

### 📦 Custom Commands

- **Run daily stock aggregation:**
```bash
php artisan stocks:aggregate
```

- **Upload stock file (via API):**  
  `POST /api/stock/upload` with a file (Excel)

- **Get stock changes for a company:**  
  `GET /api/stock/{company_name}/changes`

- **Get stock change between two dates:**  
  `GET /api/stock/{company_name}/changes/custom?start_date=YYYY-MM-DD&end_date=YYYY-MM-DD`

---

### 🚀 Horizon (Optional for Monitoring Queues)
Install Horizon for advanced queue management:
```bash
composer require laravel/horizon
php artisan horizon:install
php artisan migrate
php artisan horizon
```
Visit `http://localhost/horizon`.

---


