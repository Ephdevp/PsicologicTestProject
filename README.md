## Changelog v0.4.0 (2025-09-19)
This version introduces the first functional iteration of the personal data flow and prepares the application for psychological tests.

### Key Changes
1. Dashboard results flow:
   - Loader overlay shows “Analizando respuestas” for ~7 seconds after submission.
   - Results modal opens automatically and lists items as “Factor: {index}_Sten: {value}”.
   - Results are passed via session(`results`) from the controller.
2. Test cards behavior:
   - If a test status is `completed` (model or pivot), card renders without link and shows a green “Completed!” badge.
   - Pending tests remain clickable and show the questions counter.
3. Scoring pipeline:
   - Aggregation by factor name across answers; total score per factor calculated server-side.
   - Database function `lookup_sten` used to compute Sten; result normalized and returned to UI.
4. Database & migrations:
   - Migration to create SQL function `lookup_sten` added.
   - Collation migration to utf8mb4_unicode_ci (IMPLICIT) applied across database/tables where needed.
5. Controllers:
   - `TestController@questionarieSubmit` builds the `results` array grouped by factor and flashes it to session.
   - `DashboardController@index` loads user tests via pivot to expose status for UI rendering.

---

## (Referencia) Detalle de Funcionalidades v0.3.0

### New & Updated Features (English Summary)
1. Profile page enhancements:
   - Always-visible Personal Data form (create/update unified) with validation and English translation.
   - Conditional tests widgets section (Available Tests & Completed Tests) shown when user has personal data; auto-scrolls into view on load.
   - Red alert + warning icon when middleware redirects user without personal data (inputs highlighted).
2. Middleware: `EnsureUserHasPerson` forces users to complete personal data before navigating the app.
3. Authentication flow adjustments:
   - Registration assigns default `user_level_id = 3` (user level).
   - Post-login & post-registration redirect to profile instead of dashboard.
4. Person management:
   - Backend create & update endpoints (`person.store`, `person.update`).
   - Form supports gender options (male, female, other) and unified UX.
5. UI components:
   - Tests overview widgets (hardcoded demo data) with modern Tailwind styling.
6. Language & UX:
   - Personal Data form fully translated to English.
   - Consistent status flash keys (`person-updated`, `person_required`).
7. Seeders added/improved:
   - User levels (`super_admin`, `admin`, `user`).
   - Super admin user (`SuperAdminUserSeeder`) with default credentials.
   - Interpretation data bulk insert.
   - Sten age data bulk insert.
8. Eloquent relationships defined across models (User, Person, Question, Test, etc.).
9. Routing & bootstrap configuration updated to register custom middleware in web group (`bootstrap/app.php`).
10. Codebase cleanup & structural alignment for Laravel 12 style configuration.

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