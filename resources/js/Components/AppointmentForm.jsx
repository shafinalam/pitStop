import React, { useState } from 'react';
import { useForm } from '@inertiajs/react';

export default function AppointmentForm({ mechanics }) {
    const { data, setData, post, processing, errors } = useForm({
        mechanic_id: '',
        client_name: '',
        address: '',
        phone: '',
        car_license_number: '',
        car_engine_number: '',
        appointment_date: '',
        appointment_time: '',
        description: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('appointments.store'));
    };

    return (
        <div className="bg-white p-6 rounded-lg shadow-md appointment-form-custom">
            <h2 className="text-2xl font-semibold mb-4">Book an Appointment</h2>
            
            <form onSubmit={handleSubmit}>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {/* Mechanic Selection */}
                    <div className="mb-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="mechanic_id">
                            Select Mechanic
                        </label>
                        <select
                            id="mechanic_id"
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value={data.mechanic_id}
                            onChange={e => setData('mechanic_id', e.target.value)}
                        >
                            <option value="">Select a mechanic</option>
                            {mechanics && mechanics.map(mechanic => (
                                <option key={mechanic.id} value={mechanic.id}>
                                    {mechanic.name}
                                </option>
                            ))}
                        </select>
                        {errors.mechanic_id && <p className="text-red-500 text-xs italic">{errors.mechanic_id}</p>}
                    </div>

                    {/* Client Name */}
                    <div className="mb-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="client_name">
                            Full Name
                        </label>
                        <input
                            id="client_name"
                            type="text"
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value={data.client_name}
                            onChange={e => setData('client_name', e.target.value)}
                        />
                        {errors.client_name && <p className="text-red-500 text-xs italic">{errors.client_name}</p>}
                    </div>

                    {/* Address */}
                    <div className="mb-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="address">
                            Address
                        </label>
                        <input
                            id="address"
                            type="text"
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value={data.address}
                            onChange={e => setData('address', e.target.value)}
                        />
                        {errors.address && <p className="text-red-500 text-xs italic">{errors.address}</p>}
                    </div>

                    {/* Phone */}
                    <div className="mb-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="phone">
                            Phone Number
                        </label>
                        <input
                            id="phone"
                            type="text"
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value={data.phone}
                            onChange={e => setData('phone', e.target.value)}
                        />
                        {errors.phone && <p className="text-red-500 text-xs italic">{errors.phone}</p>}
                    </div>

                    {/* Car License Number */}
                    <div className="mb-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="car_license_number">
                            Car License Number
                        </label>
                        <input
                            id="car_license_number"
                            type="text"
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value={data.car_license_number}
                            onChange={e => setData('car_license_number', e.target.value)}
                        />
                        {errors.car_license_number && <p className="text-red-500 text-xs italic">{errors.car_license_number}</p>}
                    </div>

                    {/* Car Engine Number */}
                    <div className="mb-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="car_engine_number">
                            Car Engine Number
                        </label>
                        <input
                            id="car_engine_number"
                            type="text"
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value={data.car_engine_number}
                            onChange={e => setData('car_engine_number', e.target.value)}
                        />
                        {errors.car_engine_number && <p className="text-red-500 text-xs italic">{errors.car_engine_number}</p>}
                    </div>

                    {/* Appointment Date */}
                    <div className="mb-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="appointment_date">
                            Appointment Date
                        </label>
                        <input
                            id="appointment_date"
                            type="date"
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value={data.appointment_date}
                            onChange={e => setData('appointment_date', e.target.value)}
                        />
                        {errors.appointment_date && <p className="text-red-500 text-xs italic">{errors.appointment_date}</p>}
                    </div>

                    {/* Appointment Time */}
                    <div className="mb-4">
                        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="appointment_time">
                            Appointment Time
                        </label>
                        <input
                            id="appointment_time"
                            type="time"
                            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value={data.appointment_time}
                            onChange={e => setData('appointment_time', e.target.value)}
                        />
                        {errors.appointment_time && <p className="text-red-500 text-xs italic">{errors.appointment_time}</p>}
                    </div>
                </div>

                {/* Description */}
                <div className="mb-6">
                    <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="description">
                        Description of Issue
                    </label>
                    <textarea
                        id="description"
                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value={data.description}
                        onChange={e => setData('description', e.target.value)}
                        rows="4"
                    ></textarea>
                </div>

                {/* Submit Button */}
                <div className="flex items-center justify-end">
                    <button
                        type="submit"
                        className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        disabled={processing}
                    >
                        {processing ? 'Booking...' : 'Book Appointment'}
                    </button>
                </div>
            </form>
        </div>
    );
} 