## Changelog v0.5.3 (2025-10-07)
Enhancements to the questionnaire UX, client/server validation, and timer persistence.

### Key Changes
1. Questionnaire UX
   - Replaced auto-advance on radio selection with an explicit Next button per question.
   - The last question shows the Score button in the same position where Next appears for the others.
   - Inline validation: if Next is pressed without a selection, an alert appears below the button.

2. Timer persistence
   - Countdown now persists across page refreshes using localStorage (keyed by test id) and clears on submit/timeout.

3. Validation & robustness
   - All radio inputs are marked as required in the form (HTML5).
   - Server-side validation in TestController@questionarieSubmit ensures all questions are answered and parses inputs by key pattern `Answere_{questionId}`; no reliance on request order.
   - Safer derivation of `test_id` from the first answer's question; avoids undefined variable usage.

4. Model improvement
   - Added `Person::getAgeAttribute()` accessor deriving age from `birthdate`; removed controller getter.

### Verify
- Navigate a questionnaire:
  - Select an answer and press Next to advance. On the last question, use Score.
  - Pressing Next without a selection shows an inline alert under the button.
- Refresh the page: the countdown should not reset; when it reaches 0, the test times out as before.
- Attempt to submit with any unanswered question: the server rejects and requests completion.

### Notes
- No new migrations introduced in v0.5.3. Ensure v0.5.1 migrations are applied for the `lookup_sten` collation fix.

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