import React from 'react';
import { Head } from '@inertiajs/react';
import Navbar from '../Components/Navbar';

export default function Services() {
  return (
    <>
      <Head title="Our Services" />
      <Navbar />
      
      <div className="container">
        <h1 className="page-title">Our Services</h1>
        
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div className="card">
            <h2 className="section-title">Oil Change</h2>
            <p className="text-content">Regular oil changes to keep your engine running smoothly.</p>
          </div>
          
          <div className="card">
            <h2 className="section-title">Brake Service</h2>
            <p className="text-content">Expert brake repair and maintenance for your safety.</p>
          </div>
          
          <div className="card">
            <h2 className="section-title">Tire Replacement</h2>
            <p className="text-content">Quality tires and professional installation.</p>
          </div>
          
          <div className="card">
            <h2 className="section-title">Engine Diagnostics</h2>
            <p className="text-content">Advanced computer diagnostics to identify engine problems.</p>
          </div>
          
          <div className="card">
            <h2 className="section-title">AC Service</h2>
            <p className="text-content">Keep your car cool with our air conditioning service.</p>
          </div>
          
          <div className="card">
            <h2 className="section-title">Electrical Repair</h2>
            <p className="text-content">Fixing electrical issues in modern vehicles.</p>
          </div>
        </div>
      </div>
    </>
  );
} 