# Task Management Application

This is a Task Management application built with Laravel.
## Installation

Follow the steps below to set up the Task Management application:

1. Clone the project repository:

   ```bash
   git clone https://github.com/Paredesfabio/tasks-management.git
   ```

2. Change into the project directory:

   ```bash
   cd tasks-management
   ```

3. Install Composer dependencies:

   ```bash
   composer install
   ```

4. Install NPM dependencies:

   ```bash
   npm install
   ```

5. Build the assets:

   ```bash
   npm run build
   ```

6. Copy the `.env.template` file to `.env`:

   ```bash
   cp .env.template .env
   ```

7. Create a MySQL database and update the database credentials in the `.env` file.

8. Run the database migrations:

   ```bash
   php artisan migrate
   ```

9. Seed the database with sample data:

   ```bash
   php artisan db:seed
   ```

10. Generate the application key:

    ```bash
    php artisan key:generate
    ```

## Usage

To use the Task Management application, follow these steps:

1. Start the development server:

   ```bash
   php artisan serve
   ```

2. Visit `http://localhost:8000` in your web browser.

3. You can now create projects and tasks, manage their priorities, and perform CRUD operations on them.
