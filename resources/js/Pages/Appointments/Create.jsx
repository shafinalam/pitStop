import React, { useState, useEffect } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import Navbar from '../../Components/Navbar';

// Simple route helper function to replace the missing route() function
const route = (name) => {
  const routes = {
    'appointments.store': '/appointments'
  };
  return routes[name] || '/';
};

export default function Create({ mechanics, flash }) {
  // Log mechanics for debugging
  console.log('Mechanics received:', mechanics);
  
  const { data, setData, post, processing, errors, reset } = useForm({
    mechanic_id: '',
    client_name: '',
    email: '',
    address: '',
    phone: '',
    car_make: '',
    car_model: '',
    car_license_number: '',
    car_engine_number: '',
    service_type: '',
    appointment_date: '',
    appointment_time: '',
    description: '',
  });
  
  // State for showing success/error messages
  const [isSuccess, setIsSuccess] = useState(false);
  const [isError, setIsError] = useState(false);
  const [message, setMessage] = useState('');

  // Check for flash messages from the server
  useEffect(() => {
    if (flash && flash.message) {
      setIsSuccess(true);
      setMessage(flash.message);
      
      // Hide message after 5 seconds
      const timer = setTimeout(() => {
        setIsSuccess(false);
        setMessage('');
      }, 5000);
      
      return () => clearTimeout(timer);
    }
  }, [flash]);

  // Handle input changes
  const handleChange = (e) => {
    const { name, value } = e.target;
    setData(name, value);
  };

  // Handle form submission
  const handleSubmit = (e) => {
    e.preventDefault();
    setIsError(false);
    setIsSuccess(false);
    
    // Log form submission for debugging
    console.log('Submitting appointment form with data:', data);
    
    // Use our custom route helper
    post(route('appointments.store'), {
      onSuccess: (page) => {
        // Check if there's a flash message
        console.log('Form submission successful', page.props);
        if (page.props.flash && page.props.flash.message) {
          setMessage(page.props.flash.message);
          setIsSuccess(true);
        } else {
          setMessage('Appointment booked successfully!');
          setIsSuccess(true);
        }
        
        // Reset form after 5 seconds
        setTimeout(() => {
          reset();
          setIsSuccess(false);
          setMessage('');
        }, 5000);
      },
      onError: (errors) => {
        console.error('Form submission errors:', errors);
        setIsError(true);
        setMessage('There was a problem booking your appointment. Please check the form and try again.');
        
        // Hide error message after 5 seconds
        setTimeout(() => {
          setIsError(false);
          setMessage('');
        }, 5000);
      }
    });
  };

  return (
    <>
      <Head title="Book an Appointment" />
      <Navbar />
      
      <div className="appointment-container">
        <h1>Book Your Car Service Appointment</h1>
        
        {/* Success message */}
        {isSuccess && (
          <div className="success-message">
            {message || 'Appointment booked successfully!'}
          </div>
        )}
        
        {/* Error message */}
        {isError && (
          <div className="error-message">
            {message || 'There was a problem with your submission. Please try again.'}
          </div>
        )}
        
        {/* Form */}
        <form onSubmit={handleSubmit}>
          {/* Personal Information */}
          <h2>Personal Information</h2>
          
          <div>
            <label htmlFor="client_name">Full Name:</label>
            <input
              type="text"
              id="client_name"
              name="client_name"
              value={data.client_name}
              onChange={handleChange}
              required
            />
            {errors.client_name && <div className="error">{errors.client_name}</div>}
          </div>
          
          <div className="two-column">
            <div>
              <label htmlFor="email">Email:</label>
              <input
                type="email"
                id="email"
                name="email"
                value={data.email}
                onChange={handleChange}
                required
              />
              {errors.email && <div className="error">{errors.email}</div>}
            </div>
            
            <div>
              <label htmlFor="phone">Phone:</label>
              <input
                type="tel"
                id="phone"
                name="phone"
                value={data.phone}
                onChange={handleChange}
                required
              />
              {errors.phone && <div className="error">{errors.phone}</div>}
            </div>
          </div>
          
          <div>
            <label htmlFor="address">Address:</label>
            <input
              type="text"
              id="address"
              name="address"
              value={data.address}
              onChange={handleChange}
              required
            />
            {errors.address && <div className="error">{errors.address}</div>}
          </div>
          
          {/* Vehicle Information */}
          <h2>Vehicle Information</h2>
          
          <div className="two-column">
            <div>
              <label htmlFor="car_make">Car Make:</label>
              <input
                type="text"
                id="car_make"
                name="car_make"
                value={data.car_make}
                onChange={handleChange}
                required
                placeholder="e.g. Toyota"
              />
              {errors.car_make && <div className="error">{errors.car_make}</div>}
            </div>
            
            <div>
              <label htmlFor="car_model">Car Model:</label>
              <input
                type="text"
                id="car_model"
                name="car_model"
                value={data.car_model}
                onChange={handleChange}
                required
                placeholder="e.g. Corolla"
              />
              {errors.car_model && <div className="error">{errors.car_model}</div>}
            </div>
          </div>
          
          <div className="two-column">
            <div>
              <label htmlFor="car_license_number">License Plate Number:</label>
              <input
                type="text"
                id="car_license_number"
                name="car_license_number"
                value={data.car_license_number}
                onChange={handleChange}
                required
                placeholder="e.g. ABC-1234"
              />
              {errors.car_license_number && <div className="error">{errors.car_license_number}</div>}
            </div>
            
            <div>
              <label htmlFor="car_engine_number">Engine Number:</label>
              <input
                type="text"
                id="car_engine_number"
                name="car_engine_number"
                value={data.car_engine_number}
                onChange={handleChange}
                required
                placeholder="e.g. EN12345678"
              />
              {errors.car_engine_number && <div className="error">{errors.car_engine_number}</div>}
            </div>
          </div>
          
          {/* Mechanic Selection */}
          <h2>Select Your Mechanic</h2>
          
          <div>
            <label htmlFor="mechanic_id">Mechanic:</label>
            <select
              id="mechanic_id"
              name="mechanic_id"
              value={data.mechanic_id}
              onChange={handleChange}
              required
            >
              <option value="">Select a mechanic</option>
              {mechanics.map(mechanic => (
                <option key={mechanic.id} value={mechanic.id}>
                  {mechanic.name}
                </option>
              ))}
            </select>
            {errors.mechanic_id && <div className="error">{errors.mechanic_id}</div>}
          </div>
          
          {/* Service Information */}
          <h2>Service Information</h2>
          
          <div>
            <label htmlFor="service_type">Service Type:</label>
            <select
              id="service_type"
              name="service_type"
              value={data.service_type}
              onChange={handleChange}
              required
            >
              <option value="">Select a service</option>
              <option value="Oil Change">Oil Change</option>
              <option value="Brake Service">Brake Service</option>
              <option value="Tire Replacement">Tire Replacement</option>
              <option value="Regular Maintenance">Regular Maintenance</option>
              <option value="Other">Other</option>
            </select>
            {errors.service_type && <div className="error">{errors.service_type}</div>}
          </div>
          
          <div className="two-column">
            <div>
              <label htmlFor="appointment_date">Appointment Date:</label>
              <input
                type="date"
                id="appointment_date"
                name="appointment_date"
                value={data.appointment_date}
                onChange={handleChange}
                required
              />
              {errors.appointment_date && <div className="error">{errors.appointment_date}</div>}
            </div>
            
            <div>
              <label htmlFor="appointment_time">Appointment Time:</label>
              <input
                type="time"
                id="appointment_time"
                name="appointment_time"
                value={data.appointment_time}
                onChange={handleChange}
                required
              />
              {errors.appointment_time && <div className="error">{errors.appointment_time}</div>}
            </div>
          </div>
          
          <div>
            <label htmlFor="description">Additional Notes (Optional):</label>
            <textarea
              id="description"
              name="description"
              value={data.description}
              onChange={handleChange}
              placeholder="Add any specific requests or information about your vehicle issues"
              rows="4"
            />
            {errors.description && <div className="error">{errors.description}</div>}
          </div>
          
          {/* Submit Button */}
          <button type="submit" disabled={processing}>
            {processing ? 'Booking...' : 'Book Appointment'}
          </button>
        </form>
      </div>
    </>
  );
} 