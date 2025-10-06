# DsignLoft - Creative Brief Management System

A Laravel-based creative brief management system with role-based dashboards and API support.

## Features Implemented

### Phase 4 + Phase 5 Implementation

✅ **Authentication with Laravel Breeze**
- User authentication with login, registration, and password reset
- Vue.js integration with Inertia.js

✅ **Role-Based Access Control**
- Three user roles: Client, Designer, Admin
- Role-based middleware for route protection
- Role-specific dashboards

✅ **Database Schema**
- Users table with role field
- Packages table for service packages
- Briefs table for creative briefs
- Brief Items for detailed brief components
- Status History for tracking brief progress
- Chat Messages for communication

✅ **API Endpoints**
- `GET /api/briefs` - List all briefs (filtered by role)
- `POST /api/briefs` - Create a new brief
- `GET /api/briefs/{id}` - View a specific brief
- `PUT /api/briefs/{id}` - Update a brief
- `DELETE /api/briefs/{id}` - Delete a brief
- `GET /api/packages` - List all packages
- `GET /api/packages/{id}` - View a specific package

✅ **Dynamic Dashboards**
- **Client Dashboard**: View own briefs and their status
- **Designer Dashboard**: View assigned and all briefs
- **Admin Dashboard**: View all briefs, users, and statistics

## Installation

### Prerequisites
- PHP 8.3+
- Composer
- Node.js & NPM
- MySQL or SQLite

### Setup Steps

1. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   # For SQLite (default)
   touch database/database.sqlite
   
   # Run migrations and seed data
   php artisan migrate --seed
   ```

4. **Build Assets**
   ```bash
   npm run build
   # Or for development
   npm run dev
   ```

5. **Start Development Server**
   ```bash
   php artisan serve
   ```

## Seeded Users

The database is seeded with three test users:

| Email | Password | Role |
|-------|----------|------|
| client@dsignloft.com | password | client |
| designer@dsignloft.com | password | designer |
| admin@dsignloft.com | password | admin |

## Seeded Packages

Three service packages are pre-configured:
- **Starter** ($299): Basic logo and business card design
- **Professional** ($599): Complete branding with social media kit
- **Enterprise** ($999): Full brand identity with unlimited revisions

## API Authentication

The API uses Laravel Sanctum for authentication. To use the API:

1. Login through the web interface
2. Use the session-based authentication for API calls
3. Or generate an API token using Sanctum's token system

## Testing

Run the test suite:

```bash
# Run all tests
php artisan test

# Run specific test suites
php artisan test --filter=Auth
php artisan test --filter=BriefApiTest
php artisan test --filter=DashboardTest
```

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   ├── BriefController.php
│   │   │   └── PackageController.php
│   │   ├── Auth/ (Breeze controllers)
│   │   └── DashboardController.php
│   └── Middleware/
│       └── RoleMiddleware.php
├── Models/
│   ├── Brief.php
│   ├── BriefItem.php
│   ├── ChatMessage.php
│   ├── Package.php
│   ├── StatusHistory.php
│   └── User.php
└── Policies/
    └── BriefPolicy.php

resources/
├── js/
│   ├── Pages/
│   │   ├── Dashboard/
│   │   │   ├── Client.vue
│   │   │   ├── Designer.vue
│   │   │   └── Admin.vue
│   │   └── Auth/ (Breeze pages)
│   └── Components/ (Breeze components)
└── css/
    └── app.css

database/
├── migrations/
└── seeders/
    ├── DatabaseSeeder.php
    ├── UserSeeder.php
    └── PackageSeeder.php
```

## Key Routes

### Web Routes
- `/` - Welcome page
- `/login` - Login page
- `/register` - Registration page
- `/dashboard` - Redirects to role-specific dashboard
- `/dashboard/client` - Client dashboard
- `/dashboard/designer` - Designer dashboard
- `/dashboard/admin` - Admin dashboard

### API Routes
All API routes are prefixed with `/api` and require authentication:
- Briefs: `/api/briefs` (CRUD operations)
- Packages: `/api/packages` (Read operations)

## Technologies Used

- **Backend**: Laravel 11, PHP 8.3
- **Frontend**: Vue.js 3, Inertia.js
- **CSS**: Tailwind CSS
- **Build Tool**: Vite
- **Authentication**: Laravel Breeze with Sanctum
- **Database**: SQLite (configurable to MySQL)

## Next Steps

Future enhancements could include:
- Real-time chat implementation with WebSockets
- File upload for brief assets
- Email notifications for status changes
- Payment integration
- Advanced search and filtering
- Brief revision history
- Designer assignment system
- Client feedback system

## License

This project is open-source software.
