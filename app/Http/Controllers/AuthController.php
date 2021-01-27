<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponser;
    //
    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password'  => 'required'
        ]);

        $input = $request->only('email', 'password');

        if (!$token = Auth::attempt($input)) {
            return $this->errorResponse(
                [
                    'error' => 'Usuário ou senha inválidos'
                ],
                401
            );
        }

        return $this->respondWithToken($token);
    }
}
