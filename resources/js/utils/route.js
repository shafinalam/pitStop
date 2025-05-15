/**
 * Route helper utility for consistent route management in React
 */

const routes = {
    home: '/',
    services: '/services',
    about: '/about',
    contact: '/contact',
    
    mechanics: '/mechanics',
    
    appointments: {
        index: '/appointments',
        create: '/appointments/create',
        show: (id) => `/appointments/${id}`,
        edit: (id) => `/appointments/${id}/edit`
    },
    
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
    const parts = name.split('.');
    
    let result = routes;
    for (const part of parts) {
        if (!result[part]) {
            console.error(`Route not found: ${name}`);
            return '/';
        }
        result = result[part];
    }
    
    if (typeof result === 'function') {
        return result(params);
    }
    
    return result;
}

export default routes; 