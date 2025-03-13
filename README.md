Laravel Role-based Access Control (RBAC) API
A RESTful API system for dynamic role-based access control with record-level permissions and comprehensive audit logging.
Features

🔐 Role & Permission Management: Full CRUD operations via API
🔍 Record-level Permissions: Granular access control down to individual records
👥 Dynamic Role Assignment: Multiple roles per user with immediate effect
📝 Comprehensive Audit Trail: Complete history of all permission changes

Installation
bashCopy# Clone the repository
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
API Reference
Authentication
httpCopyPOST /api/login
Request
jsonCopy{
  "email": "admin@example.com",
  "password": "password"
}
Response
jsonCopy{
  "token": "1|example-token-string"
}
Roles
MethodEndpointDescriptionGET/api/rolesList all rolesPOST/api/rolesCreate a roleGET/api/roles/{id}Get specific rolePUT/api/roles/{id}Update a roleDELETE/api/roles/{id}Delete a role
Example: Create Role
jsonCopy{
  "name": "Editor",
  "description": "Content editor with limited access",
  "permissions": [
    {"id": 1},
    {"id": 5, "record_conditions": "{\"allowed_ids\":[1,2,3]}"}
  ]
}
Permissions
MethodEndpointDescriptionGET/api/permissionsList all permissionsPOST/api/permissionsCreate a permissionGET/api/permissions/{id}Get specific permissionPUT/api/permissions/{id}Update a permissionDELETE/api/permissions/{id}Delete a permission
Example: Create Permission
jsonCopy{
  "name": "Edit Posts",
  "description": "Edit blog posts",
  "resource": "posts",
  "action": "edit",
  "record_level": true
}
User Roles
MethodEndpointDescriptionGET/api/users/{user}/rolesGet user's rolesPOST/api/users/{user}/rolesAssign rolesDELETE/api/users/{user}/roles/{role}Remove role
Example: Assign Roles
jsonCopy{
  "roles": [1, 2, 3]
}
Audit Logs
MethodEndpointDescriptionGET/api/audit-logsList audit logsGET/api/audit-logs/{id}Get specific log
Architecture

Models: User, Role, Permission, AuditLog with appropriate relationships
Middleware: CheckPermission for validating permissions on each request
Services: AuditService for comprehensive change tracking

Security

API rate limiting
Comprehensive validation
Token-based authentication
Record-level permission checks

Default Credentials
CopyEmail: admin@example.com
Password: password
License
MIT