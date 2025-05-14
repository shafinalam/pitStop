# Car Service Center - Appointment Booking System

This is a simple web application for a car service center that allows customers to book appointments with mechanics.

## Project Overview

This project is built using:
- **Laravel** - PHP framework for the backend
- **Inertia.js** - For connecting Laravel with React
- **React** - For frontend user interfaces
- **MySQL/SQLite** - For database storage

## Features

1. **Book Appointments** - Customers can book appointments with mechanics
2. **Manage Mechanics** - View mechanics and their specialties
3. **Email Confirmations** - Send confirmation emails to customers
4. **User Authentication** - Login/register functionality

## Project Structure

### Models (Database Tables)

The application has these main models:

1. **Mechanic** (`app/Models/Mechanic.php`)
   - Represents a car mechanic with a specialty
   - Has name, specialty, availability, etc.
   - Can have many appointments

2. **Appointment** (`app/Models/Appointment.php`)
   - Represents a booking made by a customer
   - Has appointment date, time, customer details, etc.
   - Belongs to a mechanic and optionally a user

3. **User** (`app/Models/User.php`)
   - Represents a registered user
   - Can have many appointments

### Controllers (Logic)

1. **AppointmentController** (`app/Http/Controllers/AppointmentController.php`)
   - Handles creating, viewing, updating, and cancelling appointments
   - Validates appointment data
   - Sends confirmation emails

2. **MechanicController** (`app/Http/Controllers/MechanicController.php`)
   - Manages the list of available mechanics
   - Creates default mechanics if none exist

### Routes (URLs)

The routes are defined in `routes/web.php`:

- `/` - Home page
- `/appointments` - List appointments
- `/appointments/create` - Book a new appointment
- `/mechanics` - View mechanic list
- `/services` - View services offered
- `/about` - About us page
- `/contact` - Contact page

### Frontend (React)

The frontend React components are in `resources/js`:

- `resources/js/Pages/` - Main page components
- `resources/js/Components/` - Reusable components like forms, buttons, etc.

## How the Booking System Works

1. **Customer selects a mechanic** - From a list of available mechanics
2. **Customer fills in details** - Including their information and car details
3. **System checks availability** - Makes sure the mechanic is available on that date
4. **Appointment is created** - The booking is saved to the database
5. **Confirmation email** - A confirmation email is sent to the customer

## Email Configuration

The application uses Mailtrap for testing emails. The configuration is in:
- `app/Providers/MailConfigServiceProvider.php`

## Getting Started

1. Clone the repository
2. Install dependencies: `composer install` and `npm install`
3. Copy `.env.example` to `.env` and configure your database
4. Run migrations: `php artisan migrate`
5. Start the development server: `php artisan serve`
6. In another terminal, run: `npm run dev`
7. Visit http://localhost:8000 in your browser

## Explanations for Beginners

### Laravel Basics

- **Routes** - Define URLs and what happens when users visit them
- **Controllers** - Handle user requests and return responses
- **Models** - Represent database tables and their relationships
- **Views** - What users see (in this case, React components)

### React Components

- Each page is a React component
- Components can be reused across different pages
- Forms handle user input with state management

### Database Relationships

- **One-to-Many**: A mechanic can have many appointments
- **Many-to-One**: An appointment belongs to one mechanic

This project demonstrates a simple but complete web application with both frontend and backend functionality.

# Online Car Workshop Appointment System

![Project Banner](https://via.placeholder.com/1200x400) <!-- Add a banner image if available -->

Welcome to the **Online Car Workshop Appointment System**! This web application is designed to streamline the process of booking car repair appointments. Clients can easily schedule appointments with their preferred mechanics, while administrators can efficiently manage and modify appointments. The system ensures that mechanics are not overbooked and provides a seamless experience for both clients and admins.

---

## **Features**

### **User Panel**
- **Appointment Booking**: Clients can book appointments by providing their details (Name, Address, Phone, Car License Number, Car Engine Number).
- **Mechanic Selection**: Clients can choose their preferred mechanic from a list of available mechanics.
- **Date Selection**: Clients can select an appointment date.
- **Validation**: The system checks mechanic availability and prevents overbooking.
- **Duplicate Prevention**: Clients cannot book multiple appointments on the same day.

### **Admin Panel**
- **Appointment Management**: Admins can view, edit, and manage all appointments.
- **Mechanic Reassignment**: Admins can reassign mechanics or change appointment dates.
- **Slot Availability**: Admins can see the number of available slots for each mechanic.

---

## **Tech Stack**
- **Frontend**: HTML, CSS, JavaScript, Bootstrap (optional)
- **Backend**: PHP (Laravel Framework)
- **Database**: MySQL
- **Hosting**: Local (XAMPP/WAMP) or Cloud (e.g., Heroku, AWS)

---

## **Installation**

### **Prerequisites**
- PHP 7.4 or higher
- Composer (for Laravel)
- MySQL
- Web server (e.g., Apache, Nginx)

### **Steps**
1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/your-repo-name.git
   cd your-repo-name
2. Install dependencies:
   ```bash
   composer install