# DsignLoft Creative Brief System - Database Report

This report details the Laravel migrations, models, and seeders created for the Creative Brief system, including table structures, Eloquent relationships, and sample data.

## 1. Database Migrations

### `users` table (Modified)
- Added a `role` column (`string`, default `client`) to the existing `users` table.

```php
// database/migrations/2014_10_12_000000_create_users_table.php
Schema::create("users", function (Blueprint $table) {
    $table->id();
    $table->string("name");
    $table->string("email")->unique();
    $table->timestamp("email_verified_at")->nullable();
    $table->string("password");
    $table->string("role")->default("client"); // Added role field
    $table->rememberToken();
    $table->timestamps();
});
```

### `briefs` table (New)
- Stores information about creative briefs.

```php
// database/migrations/YYYY_MM_DD_HHMMSS_create_briefs_table.php
Schema::create("briefs", function (Blueprint $table) {
    $table->id();
    $table->string("title");
    $table->text("description")->nullable();
    $table->json("brand_style")->nullable();
    $table->json("colors")->nullable();
    $table->foreignId("package_id")->constrained("packages");
    $table->string("status")->default("pending");
    $table->foreignId("created_by")->constrained("users");
    $table->timestamps();
});
```

### `brief_items` table (New)
- Stores individual items related to a brief (e.g., logo type, color values).

```php
// database/migrations/YYYY_MM_DD_HHMMSS_create_brief_items_table.php
Schema::create("brief_items", function (Blueprint $table) {
    $table->id();
    $table->foreignId("brief_id")->constrained("briefs")->onDelete("cascade");
    $table->string("type");
    $table->text("value");
    $table->timestamps();
});
```

### `packages` table (New)
- Defines different creative brief packages.

```php
// database/migrations/YYYY_MM_DD_HHMMSS_create_packages_table.php
Schema::create("packages", function (Blueprint $table) {
    $table->id();
    $table->string("name");
    $table->decimal("price", 8, 2);
    $table->json("features")->nullable();
    $table->timestamps();
});
```

### `status_history` table (New)
- Tracks status changes for each brief.

```php
// database/migrations/YYYY_MM_DD_HHMMSS_create_status_history_table.php
Schema::create("status_history", function (Blueprint $table) {
    $table->id();
    $table->foreignId("brief_id")->constrained("briefs")->onDelete("cascade");
    $table->string("status");
    $table->foreignId("updated_by")->constrained("users");
    $table->timestamps();
});
```

## 2. Eloquent Models

### `User` Model (`app/Models/User.php`)
- Added `role` to `$fillable` and cast `role` to `string`.

```php
// app/Models/User.php
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        // ... other fields
        'role',
    ];

    protected $casts = [
        // ... other casts
        'role' => 'string',
    ];

    public function briefs(): HasMany
    {
        return $this->hasMany(Brief::class, 'created_by');
    }

    public function statusUpdates(): HasMany
    {
        return $this->hasMany(StatusHistory::class, 'updated_by');
    }
}
```

### `Brief` Model (`app/Models/Brief.php`)
- Defines relationships with `Package`, `User` (creator), `BriefItem`, and `StatusHistory`.

```php
// app/Models/Brief.php
class Brief extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'brand_style', 'colors', 'package_id', 'status', 'created_by',
    ];

    protected $casts = [
        'brand_style' => 'array',
        'colors' => 'array',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(BriefItem::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(StatusHistory::class);
    }
}
```

### `BriefItem` Model (`app/Models/BriefItem.php`)
- Defines `belongsTo` relationship with `Brief`.

```php
// app/Models/BriefItem.php
class BriefItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'brief_id', 'type', 'value',
    ];

    public function brief(): BelongsTo
    {
        return $this->belongsTo(Brief::class);
    }
}
```

### `Package` Model (`app/Models/Package.php`)
- Defines `hasMany` relationship with `Brief` and casts `features` to `array`.

```php
// app/Models/Package.php
class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'features',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function briefs(): HasMany
    {
        return $this->hasMany(Brief::class);
    }
}
```

### `StatusHistory` Model (`app/Models/StatusHistory.php`)
- Defines `belongsTo` relationships with `Brief` and `User` (updater).

```php
// app/Models/StatusHistory.php
class StatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'brief_id', 'status', 'updated_by',
    ];

    public function brief(): BelongsTo
    {
        return $this->belongsTo(Brief::class);
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
```

## 3. Database Seeders

### `PackageSeeder` (`database/seeders/PackageSeeder.php`)
- Seeds sample package data into the `packages` table.

```php
// database/seeders/PackageSeeder.php
class PackageSeeder extends Seeder
{
    public function run(): void
    {
        Package::create([
            'name' => 'Basic Package',
            'price' => 99.99,
            'features' => ['1 Logo Concept', '2 Revisions', 'Basic File Formats']
        ]);
        // ... other package data
    }
}
```

### `UserSeeder` (`database/seeders/UserSeeder.php`)
- Seeds sample user data with different roles (`client`, `designer`, `admin`).

```php
// database/seeders/UserSeeder.php
class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Client User',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);
        // ... other user data
    }
}
```

### `DatabaseSeeder` (`database/seeders/DatabaseSeeder.php`)
- Calls the `UserSeeder` and `PackageSeeder`.

```php
// database/seeders/DatabaseSeeder.php
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PackageSeeder::class,
        ]);
    }
}
```

## Instructions for Running Migrations and Seeders

1.  **Configure Database**: Ensure your `.env` file is configured for SQLite (or your preferred database):
    ```
    DB_CONNECTION=sqlite
    # DB_DATABASE=/path/to/your/database.sqlite (if not default)
    ```
    If using SQLite, ensure the database file exists:
    ```bash
    touch database/database.sqlite
    ```

2.  **Run Migrations and Seeders**: Execute the following command in your Laravel project root:
    ```bash
    php artisan migrate --seed
    ```
    This command will:
    -   Run all pending migrations, creating the `users` (modified), `briefs`, `brief_items`, `packages`, and `status_history` tables.
    -   Execute the `DatabaseSeeder`, which in turn calls `UserSeeder` and `PackageSeeder` to populate your database with sample data.

Your database is now set up with the Creative Brief system schema and populated with initial data.

