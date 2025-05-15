import React from 'react';
import { Link } from '@inertiajs/react';

export default function Navbar() {
    // Helper function to check if the current URL matches the given path
    const isActive = (path) => {
        return window.location.pathname === path;
    };

    return (
        <nav className="navbar">
            <div className="navbar-logo">
                <Link href="/">Car Service Center</Link>
            </div>
            
            <ul className="navbar-links">
                <li><Link href="/" className={isActive('/') ? 'active' : ''}>Home</Link></li>
                <li><Link href="/services" className={isActive('/services') ? 'active' : ''}>Services</Link></li>
                <li><Link href="/mechanics" className={isActive('/mechanics') ? 'active' : ''}>Our Mechanics</Link></li>
                <li><Link href="/appointments/create" className={isActive('/appointments/create') ? 'active' : ''}>Book Appointment</Link></li>
                <li><Link href="/about" className={isActive('/about') ? 'active' : ''}>About Us</Link></li>
                <li><Link href="/contact" className={isActive('/contact') ? 'active' : ''}>Contact</Link></li>
            </ul>
        </nav>
    );
} 