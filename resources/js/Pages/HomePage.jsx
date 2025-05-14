import React from 'react';
import Navbar from './Navbar';
import '../styles/HomePage.css';

function HomePage() {
  return (
    <div className="home-page">
      <Navbar />
      
      <header className="hero">
        <div className="hero-content">
          <h1>Welcome to Car Service Center</h1>
          <p>Professional auto service and repair you can trust</p>
          <a href="/book-appointment" className="cta-button">Book an Appointment</a>
        </div>
      </header>
      
      <section className="services-preview">
        <h2>Our Services</h2>
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
      </section>
      
      <section className="about-preview">
        <h2>Our Expert Mechanics</h2>
        <div className="features">
          <div className="feature">
            <h3>Certified Professionals</h3>
            <p>All our mechanics are certified with years of specialized experience.</p>
          </div>
          
          <div className="feature">
            <h3>Personal Service</h3>
            <p>Choose your preferred mechanic for consistent, personalized care for your vehicle.</p>
          </div>
          
          <div className="feature">
            <h3>Specialized Expertise</h3>
            <p>Our team includes specialists in engines, brakes, electrical systems, and more.</p>
          </div>
        </div>
        <div className="text-center mt-20">
          <a href="/mechanics" className="cta-button">Meet Our Mechanics</a>
        </div>
      </section>
      
      <section className="contact-preview">
        <h2>Visit Us Today</h2>
        <p>123 Auto Service Road, Carville, CA 12345</p>
        <p>Phone: (555) 123-4567</p>
        <p>Hours: Monday-Friday 8am-6pm, Saturday 9am-3pm</p>
      </section>
      
      <footer className="footer">
        <p>&copy; 2025 Car Service Center. All rights reserved.</p>
      </footer>
    </div>
  );
}

export default HomePage;