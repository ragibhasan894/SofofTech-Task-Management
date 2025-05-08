
# 🗂️ Task Management API

A Laravel 10 RESTful API for managing tasks, built with clean architecture principles:  
- 🔐 Sanctum Authentication  
- 🧠 Service-Repository Pattern  
- 📦 Resource Collections  
- 👥 Task Assignment (Many-to-Many)  
- 📄 Filtering, Sorting, Pagination  
- ✅ Feature & Unit Tests  

---

## 🚀 Installation

```bash
git clone https://github.com/your-username/task-manager.git
cd task-manager
composer install
cp .env.example .env
php artisan key:generate
```

Set up your `.env` with database credentials, then:

```bash
php artisan migrate
```

---

## ⚙️ Requirements

- PHP 8.1+
- Laravel 10.x
- Composer
- MySQL or other DB

---

## 🔐 Authentication (Sanctum)

Install Sanctum:

```bash
composer require laravel/sanctum:^3.2
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

Update `app/Http/Kernel.php` for API middleware group:

```php
\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
```

---

## 📌 Features

### ✅ Auth Endpoints

| Method | Endpoint     | Description        |
|--------|--------------|--------------------|
| POST   | `/register`  | Register a user    |
| POST   | `/login`     | Login user         |
| POST   | `/logout`    | Logout (token)     |

### ✅ Task CRUD (Protected)

| Method | Endpoint        | Description         |
|--------|------------------|---------------------|
| GET    | `/tasks`         | List tasks          |
| POST   | `/tasks`         | Create a task       |
| GET    | `/tasks/{id}`    | Show task details   |
| PUT    | `/tasks/{id}`    | Update a task       |
| DELETE | `/tasks/{id}`    | Delete a task       |

### ✅ Task Assignment

| Method | Endpoint                | Description                   |
|--------|--------------------------|-------------------------------|
| POST   | `/tasks/{id}/assign`     | Assign user to task           |

### ✅ Filtering & Sorting

Supports:
- Filter by `status`, `priority`, `due_date`
- Sort by `due_date`, `created_at` using `?sort=-due_date`
- Pagination: 10 per page

Example:
```
/tasks?status=Done&priority=High&sort=-due_date
```

---

## 🧠 Project Architecture

### 🧱 Service-Repository Pattern

- **Services** handle business logic.
- **Repositories** handle DB queries.
- **Resources/Collections** shape API output.

### 📁 Directory Layout

```
app/
├── Http/Controllers/TaskController.php
├── Http/Resources/TaskResource.php
├── Models/Task.php
├── Repositories/
│   ├── Interfaces/TaskRepositoryInterface.php
│   └── TaskRepository.php
├── Services/TaskService.php
```

---

## ✅ Example Task JSON

```json
{
  "id": 1,
  "title": "Finish Laravel API",
  "description": "Service & Repository structure",
  "due_date": "2025-05-10",
  "status": "In Progress",
  "priority": "High"
}
```

---

## 🧪 Testing

Coming soon:

```bash
php artisan test
```

Includes:
- Feature tests for all endpoints
- Unit tests for services and logic

---

## 📚 License

MIT — feel free to use and adapt!

---

## 🧑‍💻 Author

Built by [Your Name]  
Feel free to fork, improve, and contribute!
