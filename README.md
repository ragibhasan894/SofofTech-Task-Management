
# Task Management API

A clean and structured Laravel 10 RESTful API for managing tasks with authentication and task assignment.

## Features

- Laravel 10.0 with PHP 8.2.18
- Sanctum-based authentication (register, login, logout)
- Task CRUD operations
- Task assignment (admin can assign tasks to users)
- Filtering, sorting, and pagination of tasks
- Service-Repository pattern for business logic separation
- Resource collections for API responses
- Feature and unit tests

## Requirements

- PHP 8.2+
- Composer
- MySQL or other supported DB

## Installation

Clone the repository and install dependencies:

```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
```

## Authentication

Sanctum is used for token-based authentication.

### Auth Endpoints

- POST /api/register
- POST /api/login
- POST /api/logout (requires auth)

## Task Endpoints

- GET /api/tasks
- POST /api/tasks
- GET /api/tasks/{id}
- PUT /api/tasks/{id}
- DELETE /api/tasks/{id}
- POST /api/tasks/{id}/assign (admin only)

### Task Assignment Rules

- Task can be created by any user
- Only users with the role `admin` can assign tasks

## Database Seeding

A default seeder adds:

- One admin user (admin@example.com, password: admin)
- Two regular users (ragib@example.com, password: ragib, hasnat@example.com, password: hasnat)

## Testing

Feature and unit tests are written using Laravel's testing tools.

Run all tests:

```
php artisan test
```

Includes:

- Feature tests for API endpoints
- Unit tests for task assignment logic

## Architecture

This project follows the Service-Repository pattern:

- Repositories handle all DB queries
- Services handle business logic
- Resource Collections format API responses

Example structure:

```
app/
├── Http/Controllers
├── Http/Requests
├── Http/Resources
├── Models
├── Repositories
│   └── Interfaces
├── Services
```

## Notes

- Role management is handled with a `role` column in the `users` table (no separate roles table)
- `user_id` is automatically assigned as task creator during creation
- Middleware protects all task routes via Sanctum
