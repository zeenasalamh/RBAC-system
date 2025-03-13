# Laravel Role-based Access Control (RBAC) API

A RESTful API system for dynamic role-based access control with record-level permissions and comprehensive audit logging.

## Features

- 🔐 **Role & Permission Management**: Full CRUD operations via API
- 🔍 **Record-level Permissions**: Granular access control down to individual records
- 👥 **Dynamic Role Assignment**: Multiple roles per user with immediate effect
- 📝 **Comprehensive Audit Trail**: Complete history of all permission changes

---

## Installation

```bash
# Clone the repository
git clone https://github.com/yourusername/rbac-system.git
cd rbac-system

# Install dependencies
composer install

# Set up environment
cp .env.example .env
php artisan key:generate

# Run migrations and seed database
php artisan migrate --seed

# Start the server
php artisan serve
```

---

## API Reference

### Authentication

#### `POST /api/login`

**Request:**

```json
{
  "email": "admin@example.com",
  "password": "password"
}
```

**Response:**

```json
{
  "token": "1|example-token-string"
}
```

---

### Roles

| Method | Endpoint          | Description          |
|--------|------------------|----------------------|
| GET    | /api/roles       | List all roles      |
| POST   | /api/roles       | Create a role       |
| GET    | /api/roles/{id}  | Get specific role   |
| PUT    | /api/roles/{id}  | Update a role       |
| DELETE | /api/roles/{id}  | Delete a role       |

#### Example: Create Role

```json
{
  "name": "Editor",
  "description": "Content editor with limited access",
  "permissions": [
    {"id": 1},
    {"id": 5, "record_conditions": "{\"allowed_ids\":[1,2,3]}"}
  ]
}
```

---

### Permissions

| Method | Endpoint             | Description            |
|--------|----------------------|------------------------|
| GET    | /api/permissions     | List all permissions  |
| POST   | /api/permissions     | Create a permission   |
| GET    | /api/permissions/{id} | Get specific permission |
| PUT    | /api/permissions/{id} | Update a permission   |
| DELETE | /api/permissions/{id} | Delete a permission   |

#### Example: Create Permission

```json
{
  "name": "Edit Posts",
  "description": "Edit blog posts",
  "resource": "posts",
  "action": "edit",
  "record_level": true
}
```

---

### User Roles

| Method | Endpoint                 | Description            |
|--------|--------------------------|------------------------|
| GET    | /api/users/{user}/roles  | Get user's roles      |
| POST   | /api/users/{user}/roles  | Assign roles          |
| DELETE | /api/users/{user}/roles/{role} | Remove role |

#### Example: Assign Roles

```json
{
  "roles": [1, 2, 3]
}
```

---

### Audit Logs

| Method | Endpoint            | Description          |
|--------|---------------------|----------------------|
| GET    | /api/audit-logs     | List audit logs     |
| GET    | /api/audit-logs/{id} | Get specific log   |

---

## Architecture

- **Models:** `User`, `Role`, `Permission`, `AuditLog` with appropriate relationships
- **Middleware:** `CheckPermission` for validating permissions on each request
- **Services:** `AuditService` for comprehensive change tracking

---

## Security

- ✅ API rate limiting
- ✅ Comprehensive validation
- ✅ Token-based authentication
- ✅ Record-level permission checks

---

## Default Credentials

```plaintext
Email: admin@example.com
Password: password
```

---

## License

This project is licensed under the MIT License.

