import React from 'react';
import { Head } from '@inertiajs/react';
import Navbar from '../Components/Navbar';

export default function MainLayout({ children, title }) {
    return (
        <>
            <Head title={title || 'Car Service Center'} />
            <div className="main-layout">
                <Navbar />
                <main className="main-content">
                    {children}
                </main>
                <footer className="site-footer">
                    <div className="footer-content">
                        <p>&copy; {new Date().getFullYear()} Car Service Center. All rights reserved.</p>
                    </div>
                </footer>
            </div>
        </>
    );
} 