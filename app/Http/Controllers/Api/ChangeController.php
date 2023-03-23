<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class ChangeController extends Controller
{
    public function change(Request $request)
    {
        // Log::debug("This is message from change.");

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|max:255',
            'new_password' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::whereEmail($request->email)->first();

            $user->tokens()->delete();      // Destroy all tokens of $user
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json('Password changing completed');
        }

        return response()->json('User Not Found.');
    }
}
