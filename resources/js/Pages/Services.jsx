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
        
        <div className="service-cards">
          <div className="service-card">
            <h3>Oil Change</h3>
            <p>Regular oil changes to keep your engine running smoothly.</p>
          </div>
          
          <div className="service-card">
            <h3>Brake Service</h3>
            <p>Expert brake repair and maintenance for your safety.</p>
          </div>
          
          <div className="service-card">
            <h3>Tire Replacement</h3>
            <p>Quality tires and professional installation.</p>
          </div>
          
          <div className="service-card">
            <h3>Engine Diagnostics</h3>
            <p>Advanced computer diagnostics to identify engine problems.</p>
          </div>
          
          <div className="service-card">
            <h3>AC Service</h3>
            <p>Keep your car cool with our air conditioning service.</p>
          </div>
          
          <div className="service-card">
            <h3>Electrical Repair</h3>
            <p>Fixing electrical issues in modern vehicles.</p>
          </div>
        </div>
      </div>
    </>
  );
} 