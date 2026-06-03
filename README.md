# Project Single Page Design

Single page for a csutomer

## Requirements

Before starting, make sure the following software is installed:

* PHP 8.3+
* Composer
* MySQL/PostgreSQL/Sqlite
* Node.js & NPM
* Git

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/YetFix/single_page_radius.git
cd single_page_radius.git
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies

```bash
npm install
```

### 4. Create Environment File

```bash
cp .env.example .env
```

### 5. Configure Environment Variables

Update the `.env` file with your database and application settings.

Example:

```env
APP_NAME="Project Name"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=root
DB_PASSWORD=password
```

### 6. Generate Application Key

```bash
php artisan key:generate
```

### 7. Run Database Migrations

```bash
php artisan migrate
```

If seeders are available:

```bash
php artisan migrate --seed
```

### 8. Create Storage Symlink

```bash
php artisan storage:link
```

### 9. Build Frontend Assets

Development:

```bash
npm run dev
```

Production:

```bash
npm run build
```

### 10. Start the Development Server

```bash
php artisan serve
```

Application will be available at:

```text
http://127.0.0.1:8000
```
