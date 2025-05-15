import React from 'react';
import { Head, Link } from '@inertiajs/react';
import MainLayout from '../../Layouts/MainLayout';

export default function Index({ appointments }) {
    return (
        <MainLayout>
            <Head title="My Appointments" />
            
            <div className="container-sm">
                <div className="flex justify-between items-center mb-6">
                    <h1 className="page-title">My Appointments</h1>
                    <Link href={route('appointments.create')} className="btn btn-primary">
                        Book New Appointment
                    </Link>
                </div>
                
                {appointments && appointments.length > 0 ? (
                    <div className="card">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <div className="overflow-x-auto">
                                <table className="min-w-full divide-y divide-gray-200">
                                    <thead className="bg-gray-50">
                                        <tr>
                                            <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Mechanic
                                            </th>
                                            <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date & Time
                                            </th>
                                            <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody className="bg-white divide-y divide-gray-200">
                                        {appointments.map(appointment => (
                                            <tr key={appointment.id}>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {appointment.mechanic?.name}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {appointment.appointment_date} at {appointment.appointment_time}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                                                        appointment.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                        appointment.status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                                        appointment.status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                                        'bg-blue-100 text-blue-800'
                                                    }`}>
                                                        {appointment.status}
                                                    </span>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <Link 
                                                        href={route('appointments.show', appointment.id)} 
                                                        className="link mr-3"
                                                    >
                                                        View
                                                    </Link>
                                                    <Link 
                                                        href={route('appointments.edit', appointment.id)}
                                                        className="link mr-3"
                                                    >
                                                        Edit
                                                    </Link>
                                                    <Link 
                                                        href={route('appointments.destroy', appointment.id)} 
                                                        method="delete"
                                                        as="button"
                                                        className="text-red-600 hover:text-red-900"
                                                    >
                                                        Cancel
                                                    </Link>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                ) : (
                    <div className="card">
                        <div className="p-6 text-content">
                            You don't have any appointments yet. 
                            <Link href={route('appointments.create')} className="link">
                                Book your first appointment
                            </Link>.
                        </div>
                    </div>
                )}
            </div>
        </MainLayout>
    );
} 