<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\UserFormRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(UserFormRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $role = $request->input('profile');
        $data['active_role'] = $role;
        $data['external_id'] = Str::uuid()->toString();

        $user = User::create($data);

        $user->assignRole($role);

        // Enviar o e-mail de verificação
        event(new Registered($user));

        return response()->json(['message' => 'Verifique seu e-mail para verificar sua conta.'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'user' => new UserResource($user->load('roles.permissions'))
        ]);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['status' => __($status)])
            : response()->json(['email' => __($status)], 422);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? response()->json(['status' => __($status)])
            : response()->json(['email' => __($status)], 422);
    }

    public function confirmRegister($id, $hash)
    {
        $user = User::findOrFail($id);

        // Verifica se o hash está correto
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Link de verificação inválido.'], 403);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'E-mail já verificado'], 409);
        }

        if ($user->markEmailAsVerified()) {
            // Despacha evento de verificação de e-mail
            event(new \Illuminate\Auth\Events\Verified($user));
            return response()->json(['message' => 'E-mail verificado com sucesso'], 200);
        }

        return response()->json(['message' => 'Erro ao verificar e-mail'], 500);
    }

    public function resendConfirmRegister(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'O e-mail já foi verificado.'], 200);
        }

        // Enviar novamente o e-mail de verificação
        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Link de verificação enviado novamente!'], 200);
    }
}
