<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 403);
        }

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = User::where('id', Auth::id())->first();
            $token = $user->createToken('lks')->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => "Successfully logged in",
                'token_type' => 'Bearer ',
                'token' => $token,
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function logout()
    {
        $user = request()->user();
        $token = $user->currentAccessToken()->delete();

        if ($token) {
            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function me()
    {
        $user = request()->user();
        return response()->json([
            'success' => true,
            'message' => 'Account',
            'data' => $user
        ], 200);
    }

    public function reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 403);
        }

        $user = request()->user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($request->new_password);
            $user->save();
            $user->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Reset success, user logged out'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Old password did not match'
            ], 422);
        }
    }
}
