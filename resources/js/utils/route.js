/**
 * Route helper utility for consistent route management in React
 */

// Define all application routes here
const routes = {
    // Basic pages
    home: '/',
    services: '/services',
    about: '/about',
    contact: '/contact',
    
    // Mechanics
    mechanics: '/mechanics',
    
    // Appointments
    appointments: {
        index: '/appointments',
        create: '/appointments/create',
        show: (id) => `/appointments/${id}`,
        edit: (id) => `/appointments/${id}/edit`
    },
    
    // Authentication
    login: '/login',
    register: '/register',
    logout: '/logout',
};

/**
 * Get a route by name, with optional parameters
 * 
 * @param {string} name - Route name, can use dot notation for nested routes
 * @param {Object} params - Optional parameters for dynamic routes
 * @returns {string} The URL for the route
 */
export function route(name, params = {}) {
    // Split the name by dots for nested routes
    const parts = name.split('.');
    
    // Navigate the routes object
    let result = routes;
    for (const part of parts) {
        if (!result[part]) {
            console.error(`Route not found: ${name}`);
            return '/';
        }
        result = result[part];
    }
    
    // If the result is a function, call it with the params
    if (typeof result === 'function') {
        return result(params);
    }
    
    return result;
}

export default routes; 