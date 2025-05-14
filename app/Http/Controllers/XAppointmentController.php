<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class XAppointmentController extends Controller
{
    public function create()
    {
        return Inertia::render('Appointments/Create', [
            'mechanics' => [
                [
                    'id' => 1,
                    'name' => 'Alex Johnson',
                    'specialty' => 'Engine Repair',
                    'is_available' => true
                ],
                [
                    'id' => 2,
                    'name' => 'Sarah Chen',
                    'specialty' => 'Brake Systems',
                    'is_available' => true
                ]
            ]
        ]);
    }
} 