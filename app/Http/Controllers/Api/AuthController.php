<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login
     *
     * @param String email
     * @param String password
     */
    public function login(Request $request)
    {

        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'User not found',
                ], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Invalid credentials',
                ], 401);
            }

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'message'   => 'Login successful',
                'token'     => $token,
                'user'      => $user,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ], 500);
        }
    }
}
