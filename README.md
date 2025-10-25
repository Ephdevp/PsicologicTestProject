   ## Changelog v0.6.6 (2025-10-26)
   Results view overhaul and visual refinements.

   ### Key Changes
   1. Results view redesign
      - Merged the three results containers into a single consolidated layout (`resources/views/results/basic.blade.php`) and removed the Next/Back navigation controls.
      - Replaced SVG icons in shared component(s) to use `public/logo.png` so header/login and results share the same image asset.
      - Imported the Roboto font inline for the results view only and applied compact typography for denser printed/export layouts.
      - Darkened table borders and adjusted table/cell widths for better readability and print fidelity.
      - Reworked the factors visualization: header and factor cells render as 11-cell grids (-5..+5). The central cell is shown gray and side cells color green/red proportionally to the factor sten values.
      - Added a simple 4×8 static table under the EZ block for notes/annotations.

   2. Profile form and localization
      - Updated `resources/views/profile/partials/person-form.blade.php` to submit Russian `value` strings for `gender` and `education_level`, while preserving legacy matching for already stored English/Spanish values.

   3. Minor visual/UX tweaks
      - Reduced row heights on targeted tables using a `compact-table` stylesheet block.
      - Removed gaps between factor subcells to create contiguous indicator bars.
      - Combined and clarified some table headers and labels for print-friendly output.

   ### Verify
   - Open a completed Results page: the factors column should show an 11-cell grid with the center cell gray and left/right coloring reflecting the stored sten values.
   - Edit Profile: gender and education selects should accept/display legacy values while submitting the new Russian strings.
   - Check the login and navigation headers: the logo should be served from `public/logo.png`.

   ### Notes
   - No DB migrations were added in v0.6.6; changes are view-level only.
   - If you want Roboto applied globally, update `resources/css/app.css` and recompile assets (npm run build).

   ## Changelog v0.6.5 (2025-10-21)
   UI icon unification and controller cleanup.

   ### Key Changes
   1. Unified App Icon
      - Replaced the default Laravel logo in the navigation bar and login screen with the same book SVG used in results (Container 3).
      - Implemented by updating the shared Blade component `resources/views/components/application-logo.blade.php`, so all usages reflect the new icon.

   2. Controller Debug Cleanup
      - Scanned controllers for active debug statements (var_dump, dd, dump, die, print_r). No active statements were found; leftover snippets in `TestController.php` are commented and harmless.

   ### Verify
   - Open the login page and the main navigation: both should display the new book icon with current text color.
   - Run through a questionnaire and submit: there should be no accidental debug output or early termination.

   ### Notes
   - No migrations in v0.6.5.
   - To customize icon color per context, adjust `text-*` utilities where `<x-application-logo>` is used (e.g., `text-gray-800`, `text-gray-500`).

   ## Changelog v0.6.0 (2025-10-21)
   Results experience, localization defaults, and auth translations.

   ### Key Changes
   1. Results flow (basic view)
      - Single-step navigation across 3 containers with Next/Back.
      - Container 1: identity and contact spots; 6-column results table with columns 3+4 merged; factor bars with centered baseline and color (green/red) proportional to value.
      - Container 2: four explicit interpretation tables; the first row is full-width with indigo background and white text; centered content in rows 2–3.
      - Container 3: title/subtitle; centered 1-column/2-row table that labels EZ zone and colors the second row by range:
        - -20..0 → «Красная зона» (red)
        - 1..4 → «Желтая зона» (yellow)
        - 5..9 → «Салатовая зона» (light green)
        - 10..20 → «Зеленая зона» (green)
      - New recommendations block under the table shown only when EZ < 2; centered text; health notice highlighted.

   2. Dashboard
      - Error modal appears when session('error') exists, with red accent styling and dismiss actions.

   3. Profile widgets
      - Completed-tests link now has success-hover: the full link area turns green and texts turn white; widened hit area for better UX.

   4. Auth (Login / Create account)
      - Russian texts applied directly in Blade templates for labels and links (no dependency on lang files).
      - Default application locale set to Russian with Russian fallback in `config/app.php`.

   5. Misc
      - UI centering and alignment fixes across results tables and action buttons.
      - Language switcher visibility limited per results page (if present in your nav).

   ### Upgrade Notes
   - No new database migrations in v0.6.0.
   - If you prefer English by default, set `APP_LOCALE=en` and `APP_FALLBACK_LOCALE=en` in your `.env`.
   - If you maintain custom auth screens, review the Russian copy in `resources/views/auth/login.blade.php` and `resources/views/auth/register.blade.php`.

   ### Try it
   - Complete a test and open Results:
     - Navigate with Next/Back across the 3 containers.
     - Verify the EZ zone label and background color; when EZ < 2, the recommendations are shown.
   - Visit the Profile → Completed tests list and hover a result to see the success hover.
   - Visit Login and Register to confirm Russian text appears by default.

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
   2. **Update the Repository:**
      ```bash
      cd project_name
      git pull <repository-url>
      ```
   https://gitdev.s2.e9lab.com/Efrain_V_Dev/PsicologicTestProject.git

   3. **Install Dependencies:**
      ```bash
      composer install
      Or
      /usr/bin/php8.3 /usr/bin/composer install
      npm install
      npm run build
      ```

   4. **Set Up Environment Variables:**
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

   5. **Generate Application Key:**
      ```bash
      php artisan key:generate
      ```

   6. **Run Migrations:**
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