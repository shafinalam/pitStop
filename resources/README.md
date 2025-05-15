# Car Service Center - Resources Directory

This directory contains the front-end resources for the Car Service Center application.

## Structure

- **css/** - Contains the main styling for the application in app.css
- **js/** - Contains the JavaScript/React code
  - **Components/** - Reusable UI components
  - **Pages/** - Page-level components used for routing
  - **Layouts/** - Layout components used across multiple pages
  - app.jsx - Main application entry point
- **views/** - Contains Blade templates
  - **auth/** - Authentication-related views
  - **emails/** - Email templates for appointments

## Getting Started

The application uses React with Inertia.js for the frontend. All CSS has been consolidated into a single file (`css/app.css`) for simplicity.

To modify styles, edit the `app.css` file directly. To add new pages or components, create them in the appropriate directory following the existing patterns. 