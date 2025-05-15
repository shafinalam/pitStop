import React from 'react';
import { Head } from '@inertiajs/react';
import Navbar from '../Components/Navbar';

export default function Mechanics({ mechanics = [] }) {
  // Default mechanics if none were provided
  const defaultMechanics = [
    {
      id: 1,
      name: "Alex Johnson",
      specialty: "Engine Repair",
      bio: "Alex specializes in diagnosing and repairing complex engine issues. With 8 years of experience, he has worked on various car makes and models.",
      phone: "555-123-4567",
      email: "alex@carservice.com"
    },
    {
      id: 2,
      name: "Sarah Chen",
      specialty: "Brake Systems",
      bio: "Sarah is our brake system expert with over a decade of experience. She ensures your vehicle's braking system is in perfect condition for maximum safety.",
      phone: "555-234-5678",
      email: "sarah@carservice.com"
    },
    {
      id: 3,
      name: "Miguel Rodriguez",
      specialty: "Electrical Systems",
      bio: "Miguel excels in diagnosing and fixing electrical issues in modern vehicles. He stays up-to-date with the latest automotive electronics technology.",
      phone: "555-345-6789",
      email: "miguel@carservice.com"
    },
    {
      id: 4,
      name: "Priya Patel",
      specialty: "General Maintenance",
      bio: "Priya handles all aspects of routine maintenance and ensures your vehicle runs smoothly. She has comprehensive knowledge of preventative care.",
      phone: "555-456-7890",
      email: "priya@carservice.com"
    }
  ];

  // Use the passed mechanics or fall back to default ones
  const displayMechanics = mechanics.length > 0 ? mechanics : defaultMechanics;
  
  return (
    <>
      <Head title="Our Mechanics" />
      <Navbar />
      
      <div className="container">
        <h1 className="page-title">Meet Our Expert Mechanics</h1>
        <p className="text-content">
          Our team of certified mechanics are here to provide the best service for your vehicle. 
          Each specialist brings years of experience and expertise to ensure quality repairs and maintenance.
        </p>
        
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          {displayMechanics.map(mechanic => (
            <div key={mechanic.id} className="card">
              <div className="flex items-center mb-4">
                <img 
                  src={`https://randomuser.me/api/portraits/${mechanic.id % 2 === 0 ? 'women' : 'men'}/${mechanic.id * 10 + 20}.jpg`} 
                  alt={`${mechanic.name} - Car Mechanic`} 
                  className="w-20 h-20 rounded-full mr-4"
                />
                <div>
                  <h2 className="section-title">{mechanic.name}</h2>
                  <h3 className="text-blue-600 font-medium">{mechanic.specialty}</h3>
                </div>
              </div>
              
              <div>
                <p className="text-content"><strong>Experience:</strong> {mechanic.bio.includes('years') ? mechanic.bio.match(/\d+\s+years/)[0] : '5+ years'}</p>
                <p className="text-content">{mechanic.bio}</p>
                
                <div className="mt-4">
                  <strong>Contact:</strong>
                  <ul className="list-none mt-2">
                    <li className="text-content-sm">Phone: {mechanic.phone}</li>
                    <li className="text-content-sm">Email: {mechanic.email}</li>
                  </ul>
                </div>
                
                <a href="/appointments/create" className="btn btn-primary mt-4 inline-block">
                  Book with {mechanic.name.split(" ")[0]}
                </a>
              </div>
            </div>
          ))}
        </div>
      </div>
    </>
  );
} 