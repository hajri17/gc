<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'register-email' => 'required|string|email|min:5|max:255|unique:users,email',
            'register-password' => 'required|string|min:6|max:255|alpha_num|confirmed',
        ]);

        if ($validator->fails()) {
            $validator->errors()->add('register-error', 'error');

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user = new User([
                'email' => $request->input('register-email'),
                'password' => bcrypt($request->input('register-password')),
            ]);

            $user->is_admin = false;

            $user->save();
        } catch (\Exception $e) {
            Log::error('Failed to register user: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withErrors([
                    'register' => 'Failed to register user',
                ])
                ->withInput();
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home');
    }
}
