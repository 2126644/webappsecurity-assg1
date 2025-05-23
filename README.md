# Laravel To-Do App

This is a simple Laravel-based To-Do application with:

* User registration and login
* Two-Factor Authentication (2FA) via email
* Role-Based Access Control (RBAC): Admin & Student roles
* Admin dashboard to manage all users status and their to-dos
* CRUD operations for to‑dos
* Account activation/deactivation toggles

---

## Features

1. **User Registration & Login**

   * Secure registration with password hashing and unique salt per user.
   * Login protected by two-factor authentication (6‑digit code emailed).
   * **IIUM Wi-Fi disallow connections to port 587 (can't reach Gmail’s SMTP server), use mobile data.**

2. **Roles & Permissions**

   * Two roles: **Admin** (role_id = 1) and **Student** (role_id = 2).
   * By default, new users are assigned the Student role.
   * Admins can view all users and their to-dos, activate/deactivate account, and delete users; meanwhile students cannot.

3. **Admin Dashboard**

   * List all users with their user ID, name, email, role, and activation status.
   * Toggle activation with a switch (active/inactive).
   * Delete users action button.
   * Click any user to view and manage that user’s to‑dos.

4. **To-Do Management**

   * Students can create, view, edit, and **(for Admins only)** delete their own tasks.
   * Admins can view, edit, and delete any user’s tasks.

5. **Account Lockout**

   * Deactivated (if status = false) users cannot access their to-dos page (homepage).

---

## Installation

1. **Clone the repo**

   ```bash
   git clone <your-repo-url> laravel-todo-app
   cd laravel-todo-app
   ```

2. **Install dependencies**

   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Environment setup**

   * Copy `.env.example` to `.env`.
   * Set your database credentials (`DB_*`).
   * Set your mail driver (`MAIL_MAILER`, `MAIL_HOST`, etc.)
   * Generate an app key:

     ```bash
     php artisan key:generate
     ```

4. **Database migrations & seeding**

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

   This will create tables for users, todos, roles, and seed the user_roles table with Admin (1) and Student (2).

5. **Run the application**

   ```bash
   php artisan serve
   ```

   Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

---

## Usage

### Landing

* Guests are redirected to the login page.
* After login and 2FA, Students go to '/todo', Admins to '/admin/dashboar'`.

### Registration & Login

* Registration: `/register`
* Login: `/login` (password + emailed 6‑digit code)

### Two-Factor Authentication (2FA)

* After entering valid credentials, a 6‑digit code is emailed.
* Enter code at `/two-factor-challenge` to complete login.

### Admin Dashboard

* URL: '/admin/dashboard'
* List users, toggle `status` switch, delete users.
* Click a username to view/manage that user’s to-dos.

### Managing Users

* **Activate/Deactivate**: flip the switch; deactivated users cannot log in.
* **Delete**: permanently removes the user.

### Managing To-Dos

* **Students** (role\_id=2):

  * List: `/todo` (auto-reindexed rows)
  * Create: `/todo/create`
  * Edit: `/todo/{todo}/edit`
  * Delete: (*Admins only*)

* **Admins** (role\_id=1):

  * List any user’s to-dos: `/admin/users/{user}/todos`
  * Edit: `/todo/{todo}/edit`
  * Delete: `/todo/{todo}` (DELETE)

---

## Models & Migrations

* **users table**: `id`, `name`, `email`, `salt`, `password`, `role_id`, `status` (boolean), nickname, avatar, phone_no, city Timestamps.
* **todos table**: `id`, `user_id`, `title`, `description`, `status` (pending/completed), Timestamps.
* **user_roles table**: `role_id`, `role_name`, 'description', Timestamps.

---

## Custom Middleware

* **Auth**: ensures only authenticated users access protected routes.
* **Inline account status check** in controllers: blocks inactive users with 403.
