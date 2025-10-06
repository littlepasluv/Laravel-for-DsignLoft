# Laravel Breeze Installation Guide

## Overview
This project has been set up with Laravel 11 and Laravel Breeze authentication using Vue.js 3 and Inertia.js.

## Installed Components

### Backend
- **Laravel**: 11.46.1
- **Laravel Breeze**: 2.3.8
- **PHP**: 8.3.6

### Frontend
- **Vue.js**: 3.4.0
- **Inertia.js**: 2.0.10
- **Vite**: 6.3.6
- **Tailwind CSS**: 3.2.1

### Database
- **SQLite**: Configured and ready to use
- **Migrations**: All default migrations have been run

## Getting Started

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js >= 16
- npm or yarn

### Installation Steps

1. **Install PHP dependencies:**
   ```bash
   composer install
   ```

2. **Install Node dependencies:**
   ```bash
   npm install
   ```

3. **Configure environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run migrations:**
   ```bash
   php artisan migrate
   ```

5. **Build assets:**
   ```bash
   # For development
   npm run dev
   
   # For production
   npm run build
   ```

6. **Start the development server:**
   ```bash
   php artisan serve
   ```

## Authentication Features

The following authentication features are available out of the box:

- ✅ User Registration
- ✅ User Login
- ✅ Password Reset
- ✅ Email Verification
- ✅ Profile Management
- ✅ Password Confirmation
- ✅ Logout

## Available Routes

### Authentication Routes
- `GET /register` - Registration page
- `POST /register` - Register new user
- `GET /login` - Login page
- `POST /login` - Authenticate user
- `POST /logout` - Logout user
- `GET /forgot-password` - Password reset request page
- `POST /forgot-password` - Send password reset link
- `GET /reset-password/{token}` - Password reset page
- `POST /reset-password` - Reset password
- `GET /verify-email` - Email verification notice
- `GET /verify-email/{id}/{hash}` - Verify email
- `POST /email/verification-notification` - Resend verification email

### Protected Routes (require authentication)
- `GET /dashboard` - User dashboard
- `GET /profile` - User profile page
- `PATCH /profile` - Update profile
- `DELETE /profile` - Delete account

## Database Configuration

The application is configured to use SQLite by default. The configuration can be found in:
- `.env` - Database connection settings
- `config/database.php` - Database configuration
- `config/auth.php` - Authentication configuration

### Users Table
The users table includes the following columns:
- `id` - Primary key
- `name` - User's name
- `email` - User's email (unique)
- `email_verified_at` - Email verification timestamp
- `password` - Hashed password
- `remember_token` - Remember me token
- `created_at` - Creation timestamp
- `updated_at` - Update timestamp

## Testing

Run the test suite:
```bash
php artisan test
```

Run specific test suites:
```bash
# Authentication tests
php artisan test --filter=Authentication

# Registration tests
php artisan test --filter=Registration
```

## File Structure

### Vue Components
- `resources/js/Components/` - Reusable Vue components
- `resources/js/Layouts/` - Layout components
- `resources/js/Pages/` - Page components
- `resources/js/Pages/Auth/` - Authentication pages

### Controllers
- `app/Http/Controllers/Auth/` - Authentication controllers
- `app/Http/Controllers/ProfileController.php` - Profile management

### Models
- `app/Models/User.php` - User model

## Development Commands

```bash
# Start development server
php artisan serve

# Build assets for development (with hot reload)
npm run dev

# Build assets for production
npm run build

# Run tests
php artisan test

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Next Steps

Now that authentication is set up, you can:
1. Customize the authentication views in `resources/js/Pages/Auth/`
2. Add additional user fields to the registration process
3. Implement role-based authorization
4. Add social authentication providers
5. Customize email templates
6. Implement two-factor authentication

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Breeze Documentation](https://laravel.com/docs/starter-kits#laravel-breeze)
- [Inertia.js Documentation](https://inertiajs.com)
- [Vue.js Documentation](https://vuejs.org)
- [Tailwind CSS Documentation](https://tailwindcss.com)
