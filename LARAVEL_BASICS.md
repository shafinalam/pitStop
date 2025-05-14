# Laravel Basics for Beginners

This document explains the basics of Laravel for complete beginners.

## What is Laravel?

Laravel is a PHP framework for building web applications. It simplifies common tasks like:
- Routing (handling URL requests)
- Database interactions
- Authentication
- Email sending
- and much more

## Project Structure

Here's what the main folders contain:

- **app/** - Contains your application's code
  - **app/Http/Controllers/** - Classes that handle web requests
  - **app/Providers/** - Service providers that configure your app
  - **app/Models/** - Database models (if using a database)

- **routes/** - Contains route definitions
  - **routes/web.php** - Defines web routes (URLs) for your application

- **resources/** - Contains views, CSS, JavaScript, etc.
  - **resources/js/** - JavaScript files
  - **resources/views/** - Blade templates (HTML with PHP)

- **public/** - The web server's document root
  - Contains files directly accessible by users (images, CSS, JS)

- **config/** - Contains configuration files

## How Our Application Works

1. **Routes** (in routes/web.php):
   - Define what happens when a user visits a URL
   - Can return views or perform actions

2. **Views** (created with Inertia.js):
   - Provide the user interface
   - Our app uses Inertia.js which connects Laravel with React or Vue

3. **Email Sending**:
   - Uses PHPMailer to send emails through Mailtrap
   - Configuration is in app/Providers/MailConfigServiceProvider.php

## Main Features

Our Car Service Center application has these features:

1. **Static Pages**: Home, About, Services, Contact
2. **Mechanics Listing**: Shows available mechanics
3. **Appointment Booking**: Form to book a service appointment
4. **Email Confirmation**: Sends confirmation emails for appointments

## Adding New Features

To add a new feature:

1. Add a route in routes/web.php
2. Create any necessary views in resources/js/Pages
3. Add any required backend logic

## Learning More

- Official Laravel Documentation: https://laravel.com/docs
- Laracasts Tutorials: https://laracasts.com
- PHP Documentation: https://www.php.net/docs.php 