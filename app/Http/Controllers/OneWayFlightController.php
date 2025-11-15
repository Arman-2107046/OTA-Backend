<?php

namespace App\Http\Controllers;

use App\Models\OneWayFlight;
use Illuminate\Http\Request;

class OneWayFlightController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'from_city'      => 'required|string|max:255',
            'to_city'        => 'required|string|max:255',
            'departure_date' => 'required|date|after_or_equal:today',
            'adults'         => 'required|integer|min:1',
            'children'       => 'nullable|integer|min:0',
            'infants'        => 'nullable|integer|min:0',
            'cabin_class'    => 'required|string|max:50', // "economy" / "business"
        ]);

        $data['children']    = $data['children'] ?? 0;
        $data['infants']     = $data['infants'] ?? 0;
        $data['customer_id'] = $request->user()->id; // logged-in customer
        $data['status']      = 'new';

        $flight = OneWayFlight::create($data);

        return response()->json([
            'status'  => true,
            'message' => 'One-way flight request created.',
            'data'    => $flight,
        ], 201);
    }
}
