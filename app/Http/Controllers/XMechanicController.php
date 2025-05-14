<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class XMechanicController extends Controller
{
    public function index()
    {
        return Inertia::render('Mechanics', [
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