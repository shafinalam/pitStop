import React from 'react';
import Navbar from '../Components/Navbar';

export default function MainLayout({ children }) {
    return (
        <div className="min-h-screen bg-gray-100">
            <Navbar />

            <main className="py-10">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {children}
                </div>
            </main>

            <footer className="bg-white border-t border-gray-200">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16 items-center">
                        <div className="text-gray-500 text-sm">
                            © 2025 Car Workshop. All rights reserved.
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    );
} 