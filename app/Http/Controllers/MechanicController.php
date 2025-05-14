<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MechanicController extends Controller
{
    public function index()
    {
        $mechanics = Mechanic::all();
        
        return Inertia::render('Mechanics', [
            'mechanics' => $mechanics
        ]);
    }
}
