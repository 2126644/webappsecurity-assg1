Web Application Security - Assignment 3

---

Task 1: Create a new table called UserRoles to identify the user roles
Task 2: Create a new table called RolePermissions to identify what the user can do (CRUD)

Database tables:
* users table: `id`, `name`, `email`, `salt`, `password`, `role_id`, `status` (boolean), `nickname`, `avatar`, `dphone_no`, `city`, Timestamps
* todos table: `id`, `user_id`, `title`, `description`, `status` (pending/completed), Timestamps
* user_roles table: `role_id`, `role_name`, `description`, Timestamps
* role_permissions table: `permission_id`, `role_id`, `description`, Timestamps

---

Task 3: Implement Role-Based Access Control (RBAC) to redirect registered Users to the user page and Administrator to administration page

* Two roles: Admin (`role_id = 1`) and User (`role_id = 2`).
* By default, new users are assigned the User role.

Admin
* Admin dashboard list all users with their user ID, name, email, role, and activation status.
* Admins can:
  View all users and their to-dos
  Edit user to-dos
  Delete user to-dos
  Activate/deactivate user accounts
  Delete user records

User
* User dashboard list their to-dos list (task name, description, task status).
* Users can:
  View all their to-dos
  Edit to-dos
  Edit profile
* Deactivated (if `status = false`) users cannot access their to-dos page (homepage).
