import React from 'react';
import { Head } from '@inertiajs/react';
import Navbar from '../Components/Navbar';

export default function About() {
  return (
    <>
      <Head title="About Us" />
      <Navbar />
      
      <div className="container">
        <h1 className="page-title">About Car Service Center</h1>
        
        <div className="card">
          <h2 className="section-title">Our Story</h2>
          <p className="text-content">
            Car Service Center was founded in 2010 with a simple mission: to provide honest, reliable automotive repair services to our community. What started as a small garage with just two mechanics has grown into a full-service auto repair facility with a team of certified professionals.
          </p>
          <p className="text-content">
            We take pride in our work and stand behind every repair we make. Our technicians are ASE-certified and continuously trained on the latest automotive technologies and repair techniques.
          </p>
        </div>
        
        <div className="card">
          <h2 className="section-title">Our Values</h2>
          <ul className="list-disc pl-5 text-content space-y-2">
            <li><strong>Integrity:</strong> We believe in honest communication and transparent pricing.</li>
            <li><strong>Quality:</strong> We use only quality parts and stand behind our work.</li>
            <li><strong>Customer Service:</strong> Your satisfaction is our top priority.</li>
            <li><strong>Expertise:</strong> Our team is continuously trained on the latest automotive technologies.</li>
            <li><strong>Community:</strong> We're proud to serve and support our local community.</li>
          </ul>
        </div>
        
        <div className="card">
          <h2 className="section-title">Our Facility</h2>
          <p className="text-content">
            Our state-of-the-art facility is equipped with the latest diagnostic and repair equipment. We maintain a clean, professional environment where you can feel comfortable while waiting for your vehicle.
          </p>
          <p className="text-content">
            We're located at 123 Auto Service Road, Carville, CA 12345, with convenient hours Monday through Saturday.
          </p>
        </div>
      </div>
    </>
  );
} 