## Changelog v0.5.1 (2025-10-01)
This version fixes the “Illegal mix of collations (utf8mb4_unicode_ci,IMPLICIT) and (utf8mb4_general_ci,IMPLICIT)” error raised when calling the database function `lookup_sten`.

### Key Changes
1. Database
   - Added migration `2025_10_01_000000_recreate_lookup_sten_with_unicode_collation.php` that drops and recreates the SQL function `lookup_sten`.
   - The function now explicitly uses `utf8mb4_unicode_ci` for its string parameters and comparisons, ensuring consistent collation with the schema.
   - No data model changes to tables; only the function is replaced.

2. Stability
   - Resolves MySQL error HY000 1267 caused by collation mismatch during `sex` and `factor` comparisons inside the function.

### Upgrade Notes
- Run the migrations to recreate the function:

```powershell
php artisan migrate
```

- Optional: rollback only this migration if necessary:

```powershell
php artisan migrate:rollback --path=database/migrations/2025_10_01_000000_recreate_lookup_sten_with_unicode_collation.php
```

### Troubleshooting
- Ensure the database/tables are on `utf8mb4_unicode_ci`. This repo includes `2025_09_18_091500_convert_collations_to_utf8mb4_unicode_ci.php` to enforce it at the schema/table level.
- If issues persist, verify the function exists and was recreated after the collation conversion migration.

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Installation Steps

Follow these steps to set up the application:

1. **Clone the Repository:**
   ```bash
   git clone <repository-url>
   cd project_name
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Set Up Environment Variables:**
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update the `.env` file with your database credentials:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations:**
   ```bash
   php artisan migrate --seed
   ```

6. **Login with Super Admin (seeded):**
   - Email: `superadmin@example.com`
   - Password: `password` (change immediately in production).

7. **Start the Development Server:**
   ```bash
   php artisan serve
   ```

Your application should now be running at [http://localhost:8000](http://localhost:8000).