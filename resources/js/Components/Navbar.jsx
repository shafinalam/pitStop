import React from 'react';
import { Link } from '@inertiajs/react';
import '../../css/navbar.css';

export default function Navbar() {
    return (
        <nav className="navbar">
            <div className="navbar-logo">
                <Link href="/">Car Service Center</Link>
            </div>
            
            <ul className="navbar-links">
                <li><Link href="/" className="active">Home</Link></li>
                <li><Link href="/services">Services</Link></li>
                <li><Link href="/mechanics">Our Mechanics</Link></li>
                <li><Link href="/appointments/create">Book Appointment</Link></li>
                <li><Link href="/about">About Us</Link></li>
                <li><Link href="/contact">Contact</Link></li>
            </ul>
        </nav>
    );
} 