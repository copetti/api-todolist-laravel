<?php

namespace App\Services;

use App\Events\ForgotPassword;
use App\Events\UserRegistered;
use App\Exceptions\LoginInvalidException;
use App\Exceptions\ResetPasswordTokenInvalidException;
use App\Exceptions\UserHasBeenTakenException;
use App\Exceptions\VerifyEmailTokenInvalidException;
use App\Http\Resources\UserResource;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Str;
use Mockery\Generator\StringManipulation\Pass\Pass;

class AuthService
{
    public function login(string $email, string $password)
    {
        $login = [
            'email' => $email,
            'password' => $password
        ];

        if(!$token = auth()->attempt($login)){
            throw new LoginInvalidException();
        }

        return [
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];
    }

    public function register(string $firstName, string $lastName, string $email, string $password)
    {
        $user = User::where('email', $email)->exists();

        if(!empty($user)){
            throw new UserHasBeenTakenException();
        }

        $userPassword = bcrypt($password ?? Str::random(10));

        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $userPassword,
            'confirmation_token' => Str::random(60)
        ]);

        event(new UserRegistered($user));

        return $user;
    }

    public function verifyEmail(string $token)
    {
        $user = User::where('confirmation_token', $token)->first();

        if(empty($user)){
            throw new VerifyEmailTokenInvalidException();
        }

        $user->confirmation_token = null;
        $user->email_verified_at = now();
        $user->save();

        return $user;
    }

    public function forgotPassword(string $email)
    {
        $user = User::where('email', $email)->firstOrFail();

        $token = Str::random(60);

        PasswordReset::create([
            'email' => $user->email,
            'token' => $token
        ]);

//        if(!empty($user)){
//            PasswordReset::where('email', $email)->update([
//                'token' => $token
//            ]);
//        }else{
//            PasswordReset::create([
//                'email' => $user->email,
//                'token' => $token
//            ]);
//        }

        event(new ForgotPassword($user, $token));

        return '';
    }

    public function resetPassword(string $email, string $password, string $token)
    {
        $passReset = PasswordReset::where(['email' => $email, 'token' => $token])->first();

        if(empty($passReset)){
            throw new ResetPasswordTokenInvalidException();
        }

        $user = User::where('email', $email)->firstOrFail();
        $user->password = bcrypt($password);
        $user->save();

        PasswordReset::where('email', $email)->delete();

        return '';
    }
}
