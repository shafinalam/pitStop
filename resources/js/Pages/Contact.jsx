import React from 'react';
import { Head } from '@inertiajs/react';
import Navbar from '../Components/Navbar';

export default function Contact() {
  return (
    <>
      <Head title="Contact Us" />
      <Navbar />
      
      <div className="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 className="text-3xl font-bold text-gray-900 mb-6">Contact Us</h1>
        
        <div className="bg-white p-6 rounded-lg shadow-md mb-8">
          <h2 className="text-xl font-semibold text-gray-900 mb-4">Get In Touch</h2>
          <p className="text-gray-600 mb-4">
            Have questions about our services or need to schedule an appointment? We're here to help! Reach out to us using any of the methods below or fill out the contact form.
          </p>
          
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
              <h3 className="text-lg font-medium text-gray-900 mb-2">Contact Information</h3>
              <p className="text-gray-600 mb-1"><strong>Address:</strong> 123 Auto Service Road, Carville, CA 12345</p>
              <p className="text-gray-600 mb-1"><strong>Phone:</strong> (555) 123-4567</p>
              <p className="text-gray-600 mb-1"><strong>Email:</strong> info@carservicecenter.com</p>
              <p className="text-gray-600 mb-4"><strong>Hours:</strong> Monday-Friday 8am-6pm, Saturday 9am-3pm</p>
            </div>
            
            <div>
              <h3 className="text-lg font-medium text-gray-900 mb-2">Send Us a Message</h3>
              <form className="space-y-4">
                <div>
                  <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-1">Name</label>
                  <input 
                    type="text" 
                    id="name" 
                    className="w-full px-3 py-2 border border-gray-300 rounded-md"
                    placeholder="Your name"
                  />
                </div>
                
                <div>
                  <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-1">Email</label>
                  <input 
                    type="email" 
                    id="email" 
                    className="w-full px-3 py-2 border border-gray-300 rounded-md"
                    placeholder="Your email"
                  />
                </div>
                
                <div>
                  <label htmlFor="message" className="block text-sm font-medium text-gray-700 mb-1">Message</label>
                  <textarea 
                    id="message" 
                    rows="4" 
                    className="w-full px-3 py-2 border border-gray-300 rounded-md"
                    placeholder="How can we help you?"
                  ></textarea>
                </div>
                
                <button 
                  type="submit" 
                  className="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700"
                >
                  Send Message
                </button>
              </form>
            </div>
          </div>
        </div>
        
        <div className="bg-white p-6 rounded-lg shadow-md">
          <h2 className="text-xl font-semibold text-gray-900 mb-4">Our Location</h2>
          <div className="aspect-w-16 aspect-h-9 h-96 bg-gray-200 rounded-md">
            {/* In a real app, you'd embed a Google Map here */}
            <div className="flex items-center justify-center h-full">
              <p className="text-gray-600">Map would be displayed here</p>
            </div>
          </div>
        </div>
      </div>
    </>
  );
} 