## Psicologic Test Project v0.2.5

### New & Updated Features
1. Profile page enhancements:
   - Always-visible Personal Data form (create/update unified) with validation and English translation.
   - Conditional tests widgets section (Available Tests & Completed Tests) shown when user has personal data.
   - Auto-scroll to tests widgets on load when present.
   - Red alert + warning icon when middleware redirects user without personal data (inputs highlighted).
2. Middleware: `EnsureUserHasPerson` forces users to complete personal data before navigating the app.
3. Authentication flow adjustments:
   - Registration assigns default `user_level_id = 3` (user level).
   - Post-login & post-registration redirect to profile instead of dashboard.
4. Person management:
   - Backend create & update endpoints (`person.store`, `person.update`).
   - Form supports gender options (male, female, other).
5. UI components:
   - Tests overview widgets (hardcoded demo data for now) with modern Tailwind styling.
6. Language & UX:
   - Personal Data form fully translated to English.
   - Consistent status flash keys (`person-updated`, `person_required`).
7. Seeders added/improved:
   - User levels (`super_admin`, `admin`, `user`).
   - Interpretation data bulk insert.
   - Sten age data bulk insert.
8. Eloquent relationships defined across models (User, Person, Question, Test, etc.).
9. Routing & bootstrap configuration updated to register custom middleware in web group.
10. Codebase cleanup & structural alignment for Laravel 12 style (`bootstrap/app.php` middleware config).

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
   php artisan migrate
   ```

6. **Start the Development Server:**
   ```bash
   php artisan serve
   ```

Your application should now be running at [http://localhost:8000](http://localhost:8000).