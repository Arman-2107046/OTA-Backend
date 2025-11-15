<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // REGISTER: name, phone, email, password
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'email'    => 'required|email|unique:customers,email',
            'password' => 'required|string|min:6',
        ]);

        $customer = Customer::create([
            'name'     => $data['name'],
            'phone'    => $data['phone'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // create token for this customer
        $token = $customer->createToken('customer_auth')->plainTextToken;

        return response()->json([
            'status'   => true,
            'message'  => 'Registered and logged in.',
            'customer' => $customer,
            'token'    => $token,
        ], 201);
    }

    // LOGIN: email + password
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('email', $data['email'])->first();

        if (! $customer || ! Hash::check($data['password'], $customer->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid credentials',
            ], 422);
        }

        $token = $customer->createToken('customer_auth')->plainTextToken;

        return response()->json([
            'status'   => true,
            'message'  => 'Logged in.',
            'customer' => $customer,
            'token'    => $token,
        ]);
    }

    // CURRENT CUSTOMER (for profile icon / auto-login)
    public function me(Request $request)
    {
        return $request->user(); // this will be Customer from Sanctum token
    }
}
