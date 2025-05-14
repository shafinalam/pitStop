import React from 'react';
import { Head } from '@inertiajs/react';
import Navbar from '../Components/Navbar';

export default function Services() {
  return (
    <>
      <Head title="Our Services" />
      <Navbar />
      
      <div className="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 className="text-3xl font-bold text-gray-900 mb-6">Our Services</h1>
        
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div className="bg-white p-6 rounded-lg shadow-md">
            <h2 className="text-xl font-semibold text-gray-900 mb-2">Oil Change</h2>
            <p className="text-gray-600">Regular oil changes to keep your engine running smoothly.</p>
          </div>
          
          <div className="bg-white p-6 rounded-lg shadow-md">
            <h2 className="text-xl font-semibold text-gray-900 mb-2">Brake Service</h2>
            <p className="text-gray-600">Expert brake repair and maintenance for your safety.</p>
          </div>
          
          <div className="bg-white p-6 rounded-lg shadow-md">
            <h2 className="text-xl font-semibold text-gray-900 mb-2">Tire Replacement</h2>
            <p className="text-gray-600">Quality tires and professional installation.</p>
          </div>
          
          <div className="bg-white p-6 rounded-lg shadow-md">
            <h2 className="text-xl font-semibold text-gray-900 mb-2">Engine Diagnostics</h2>
            <p className="text-gray-600">Advanced computer diagnostics to identify engine problems.</p>
          </div>
          
          <div className="bg-white p-6 rounded-lg shadow-md">
            <h2 className="text-xl font-semibold text-gray-900 mb-2">AC Service</h2>
            <p className="text-gray-600">Keep your car cool with our air conditioning service.</p>
          </div>
          
          <div className="bg-white p-6 rounded-lg shadow-md">
            <h2 className="text-xl font-semibold text-gray-900 mb-2">Electrical Repair</h2>
            <p className="text-gray-600">Fixing electrical issues in modern vehicles.</p>
          </div>
        </div>
      </div>
    </>
  );
} 