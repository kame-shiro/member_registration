<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class RegisterController extends Controller
{

    public function tmp_register(Request $request)
    {
        // Log::debug("This is message from tmp_register.");

        /** @var Illuminate\Validation\Validator $validator */
        $validator = Validator::make($request->all(), [
            // 'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            // 'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $user = User::create([
            'name' => '',
            'email' => $request->email,
            'password' => ''
        ]);
        $user->val_token = uniqid(bin2hex(random_bytes(13)), true);
        $user->val_expiration = now()->addMinutes(5);
        $user->save();

        $dataArray['text'] = "Verification Code is {$user->val_token}";
        $dataArray['email'] = $user->email;

        Mail::raw($dataArray['text'], function ($message) use ($dataArray) {
            $message
                ->to($dataArray['email'])
                ->subject('Verification Mail');
        });

        $token = $user->val_token;

        return response()->json(['token' => $token]);
    }


    public function def_register(Request $request)
    {
        // Log::debug("This is message from def_register.");

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
            'token' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $user = User::whereEmail($request->email)->first();

        if ($user->val_token == $request->token && now() < $user->val_expiration) {
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->save();
        } else {
            $user->delete();
            return response()->json('User registration failed.');
        }

        // event(new Registered($user));

        return response()->json('User registration completed.');
    }
}
