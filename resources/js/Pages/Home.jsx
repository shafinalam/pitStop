import React from 'react';
import { Head, Link } from '@inertiajs/react';
import Navbar from '../Components/Navbar';

export default function Home() {
  return (
    <>
      <Head title="Welcome to Car Service Center" />
      <Navbar />
      
      <div className="hero">
        <h1>Car Service Center</h1>
        <p>Professional auto service and repair you can trust</p>
        <Link href="/appointments/create" className="cta-button">Book an Appointment</Link>
      </div>
      
      <div className="container">
        <h2 className="section-title">Our Services</h2>
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
        </div>
        
        <h2 className="section-title">Our Expert Mechanics</h2>
        <div className="features">
          <div className="feature">
            <h3>Certified Professionals</h3>
            <p>All our mechanics are certified with years of experience.</p>
          </div>
          
          <div className="feature">
            <h3>Personal Service</h3>
            <p>Choose your preferred mechanic for consistent service.</p>
          </div>
          
          <div className="feature">
            <h3>Specialized Expertise</h3>
            <p>Specialists in engines, brakes, electrical systems, and more.</p>
          </div>
        </div>
        
        <p className="text-center">
          <Link href="/mechanics" className="btn btn-primary">Meet Our Mechanics</Link>
        </p>
      </div>
      
      <div className="contact-preview">
        <h2>Visit Us Today</h2>
        <p>123 Auto Service Road, Carville, CA 12345</p>
        <p>Phone: (555) 123-4567</p>
        <p>Hours: Monday-Friday 8am-6pm, Saturday 9am-3pm</p>
      </div>
      
      <footer className="footer">
        <p>&copy; 2025 Car Service Center. All rights reserved.</p>
      </footer>
    </>
  );
} 