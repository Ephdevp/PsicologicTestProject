## Changelog v0.5.4 (2025-10-20)
Profile personal data improvements and data consistency updates.

### Key Changes
1. Person form enhancements
   - Added “Phone Number” and “Education Level” fields to the Person create/update form.
   - Education Level is now a select with options: Secondary school, High school, University education, Master's degree, Doctorate.
   - Backward compatible: previously saved Spanish values are automatically matched to the equivalent English option in the UI.

2. Validation and consistency
   - Gender validation aligned with DB enum to only allow male/female (prevents invalid values).
   - Added server-side validation for phone (max 20 chars) and education_level (max 50 chars).

3. Seed data consistency
   - Updated `database/seeders/data/questions_dump.sql` to align `factor_id` values with `questions.sql` using the mapping 1=A, 2=B, 3=C, 4=E, 5=F, 6=G, 7=H, 8=I, 9=L, 10=M, 11=N, 12=O, 13=Q1, 14=Q2, 15=Q3, 16=Q4. Content and order unchanged.

### Upgrade Notes
- No new migrations in v0.5.4 (the `people` table already contains `phone` and `education_level`).
- If you previously stored Spanish values for `education_level`, the UI will display their English equivalents. Optionally normalize existing records to English with a one-off data update if needed.

### Try it
- Go to Profile → Personal Data, enter a phone number and choose an education level, then Save. Edit works the same.

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
   Or
   /usr/bin/php8.3 /usr/bin/composer install
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
   /usr/bin/php8.3 artisan migrate --seed
   ```

6. **Login with Super Admin (seeded):**
   - Email: `superadmin@example.com`
   - Password: `password` (change immediately in production).

7. **Start the Development Server:**
   ```bash
   php artisan serve
   ```

Your application should now be running at [http://localhost:8000](http://localhost:8000).