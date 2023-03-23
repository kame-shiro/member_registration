<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class ResetController extends Controller
{
    public function tmp_reset(Request $request)
    {
        // Log::debug("This is message from tmp_reset.");

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->messages());
        }

        $user = User::whereEmail($request->email)->first();
        if (isset($user)) {
            $user->val_token = uniqid(bin2hex(random_bytes(13)), true);
            $user->val_expiration = now()->addMinutes(5);
            $user->save();

            $dataArray['text'] = "Verification Code is {$user->val_token}";
            $dataArray['email'] = $user->email;

            Mail::raw($dataArray['text'], function ($message) use ($dataArray) {
                $message
                    ->to($dataArray['email'])
                    ->subject('Mail to Reset Password');
            });

            $token = $user->val_token;

            return response()->json(['token' => $token]);
        }

        return response()->json('User Not Found.');
    }



    public function def_reset(Request $request)
    {
        // Log::debug("This is message from def_reset.");

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
            'token' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $user = User::whereEmail($request->email)->first();

        if ($user->val_token == $request->token && now() < $user->val_expiration) {
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json('Password resetting completed');
        }

        // event(new Registered($user));

        return response()->json('Password resetting failed');
    }
}
