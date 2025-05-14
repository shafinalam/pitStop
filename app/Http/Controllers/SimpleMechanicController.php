<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class SimpleMechanicController extends Controller
{
    public function index()
    {
        // Just return the view with dummy data
        return Inertia::render('Mechanics', [
            'mechanics' => [
                [
                    'id' => 1,
                    'name' => 'Alex Johnson',
                    'specialty' => 'Engine Repair',
                    'bio' => 'Expert with 8 years experience',
                    'phone' => '555-123-4567',
                    'email' => 'alex@carservice.com',
                    'is_available' => true
                ],
                [
                    'id' => 2,
                    'name' => 'Sarah Chen',
                    'specialty' => 'Brake Systems',
                    'bio' => 'Brake systems expert',
                    'phone' => '555-234-5678',
                    'email' => 'sarah@carservice.com',
                    'is_available' => true
                ],
                [
                    'id' => 3,
                    'name' => 'Miguel Rodriguez',
                    'specialty' => 'Electrical Systems',
                    'bio' => 'Electrical systems expert',
                    'phone' => '555-345-6789',
                    'email' => 'miguel@carservice.com',
                    'is_available' => true
                ],
                [
                    'id' => 4,
                    'name' => 'Priya Patel',
                    'specialty' => 'General Maintenance',
                    'bio' => 'General maintenance specialist',
                    'phone' => '555-456-7890',
                    'email' => 'priya@carservice.com',
                    'is_available' => true
                ]
            ]
        ]);
    }
} 