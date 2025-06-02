<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;  
use App\Models\VoucherCode;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $voucherCode = Str::upper(Str::random(5));

        VoucherCode::create([
            'user_id' => $user->id,    
            'code' => $voucherCode
        ]);


        Mail::to($user->email)->send(new WelcomeMail($user->first_name, $voucherCode));

        return response()->json(['message' => 'User registered successfully. Please check your email for the voucher code.'], 201);
    }
}
