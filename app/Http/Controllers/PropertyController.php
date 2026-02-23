<?php

namespace App\Http\Controllers;

use App\Models\Property;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::orderBy('name')->get();

        return view('properties.index', compact('properties'));
    }

    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }
}
