<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->getData());

        $token = $user->createToken('laravel_api_token')->plainTextToken;

        return response()->json([
            'message' => 'success',
            'data' => $user,
            'token' => $token
        ]);
    }
}
