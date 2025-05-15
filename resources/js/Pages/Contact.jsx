import React from 'react';
import { Head } from '@inertiajs/react';
import Navbar from '../Components/Navbar';

export default function Contact() {
  return (
    <>
      <Head title="Contact Us" />
      <Navbar />
      
      <div className="container">
        <h1 className="page-title">Contact Us</h1>
        
        <div className="card">
          <h2 className="section-title">Get In Touch</h2>
          <p className="text-content">
            Have questions about our services or need to schedule an appointment? We're here to help! Reach out to us using any of the methods below or fill out the contact form.
          </p>
          
          <div className="grid-layout">
            <div>
              <h3 className="section-title">Contact Information</h3>
              <p className="text-content-sm"><strong>Address:</strong> 123 Auto Service Road, Carville, CA 12345</p>
              <p className="text-content-sm"><strong>Phone:</strong> (555) 123-4567</p>
              <p className="text-content-sm"><strong>Email:</strong> info@carservicecenter.com</p>
              <p className="text-content"><strong>Hours:</strong> Monday-Friday 8am-6pm, Saturday 9am-3pm</p>
            </div>
            
            <div>
              <h3 className="section-title">Send Us a Message</h3>
              <form>
                <div className="form-group">
                  <label htmlFor="name" className="form-label">Name</label>
                  <input 
                    type="text" 
                    id="name" 
                    className="form-input"
                    placeholder="Your name"
                  />
                </div>
                
                <div className="form-group">
                  <label htmlFor="email" className="form-label">Email</label>
                  <input 
                    type="email" 
                    id="email" 
                    className="form-input"
                    placeholder="Your email"
                  />
                </div>
                
                <div className="form-group">
                  <label htmlFor="message" className="form-label">Message</label>
                  <textarea 
                    id="message" 
                    rows="4" 
                    className="form-textarea"
                    placeholder="How can we help you?"
                  ></textarea>
                </div>
                
                <button 
                  type="submit" 
                  className="btn btn-primary"
                >
                  Send Message
                </button>
              </form>
            </div>
          </div>
        </div>
        
        <div className="card">
          <h2 className="section-title">Our Location</h2>
          <div className="aspect-w-16 aspect-h-9 h-96 bg-gray-200 rounded-md">
            {/* In a real app, you'd embed a Google Map here */}
            <div className="flex items-center justify-center h-full">
              <p className="text-content">Map would be displayed here</p>
            </div>
          </div>
        </div>
      </div>
    </>
  );
} 