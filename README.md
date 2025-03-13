# Role-Based Access Control (RBAC) System

## Project Overview
A Laravel-based RESTful API for dynamic role-based access control with comprehensive auditing capabilities.

## Features
- Dynamic role and permission management
- Granular, record-level access control
- Comprehensive audit logging
- Secure authentication with Laravel Sanctum
- Rate limiting and robust security measures

## Prerequisites
- PHP 8.1+
- Composer
- MySQL 8.0+
- Laravel 10.x

## Installation Steps

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/rbac-system.git
cd rbac-system
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup
```bash
php artisan migrate:fresh --seed
php artisan passport:install
```

## Architecture Overview

### Core Components
- **Models**: User, Role, Permission, AuditLog
- **Traits**: Auditable (for logging model changes)
- **Services**: AuditService for comprehensive logging
- **Middleware**: 
  - Role-based access control
  - Permission checking
  - Rate limiting

### Security Measures
- Token-based authentication
- Role and permission-based access
- Request validation
- Rate limiting (60 requests/minute)

## API Endpoints

### Roles
- `GET /api/roles`: List all roles
- `POST /api/roles`: Create a new role
- `PUT /api/roles/{id}`: Update a role
- `DELETE /api/roles/{id}`: Delete a role

### Permissions
- `GET /api/permissions`: List all permissions
- `POST /api/permissions`: Create a new permission

## Authentication
Uses Laravel Sanctum for token-based authentication.

### Generating Tokens
```bash
php artisan tinker
$user = User::find(1);
$token = $user->createToken('API Token')->plainTextToken;
```

## Testing
```bash
php artisan test
```

## Assumptions & Limitations
- Admin users have full system access
- Permissions are managed at the system level
- Audit logs are stored in the database
- No external authentication providers integrated

## Security Recommendations
- Use HTTPS in production
- Regularly rotate authentication tokens
- Implement additional multi-factor authentication
- Conduct periodic security audits

## Troubleshooting
- Clear caches: `php artisan optimize:clear`
- Regenerate docs: `php artisan l5-swagger:generate`

## License
MIT License