## Changelog v0.5.2 (2025-10-01)
Maintenance release focused on documentation and operability around the collation fix introduced in v0.5.1.

### Key Changes
1. Fixed an error when displaying the dashboard view for users without records in the `test_user` table.
2. Added a 'Buy more tests' link in the `tests-widgets` widget on the profile view. 
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