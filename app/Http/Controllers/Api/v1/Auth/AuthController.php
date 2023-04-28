<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Api\v1\BasicController;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends BasicController
{
    public function login(Request $request): JsonResponse
    {
        $input = $request->all();
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if(Auth::attempt(array($fieldType => $input['username'], 'password' => $input['password'] ))){
            $authUser = Auth::user();
            $success['token'] =  $authUser->createToken('MyAuthApp')->plainTextToken;
            $success['name']  =  $authUser;

            return $this->sendResponse($success, 'User signed in');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function register(Request $request): JsonResponse
    {
        $userExists = User::withTrashed()->where('email',$request->email)->orWhere('username',$request->username)->first();

        if ($userExists && $userExists->trashed()){

            $userExists->restore();
            $userExists->update(['status' => 'active']);

            $success['token'] =  $userExists->createToken('MyAuthApp')->plainTextToken;
            $success['user'] =  $userExists;
        }else {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ]);

            if($validator->fails()){
                return $this->sendError('Error validation', $validator->errors());
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
            $success['user'] =  $user;
        }


        return $this->sendResponse($success, 'User created successfully.');
    }

    public function logout(Request $request): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => ' user logout'],'200');
    }


    public function getAuthenticatedUser(Request $request): JsonResponse
    {
        return response()->json(['data'=> $request->user()],'200');
    }

    public function sendPasswordResetLinkEmail(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)], 200);
        } else {
            throw ValidationException::withMessages([
                'email' => __($status)
            ]);
        }
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if($status == Password::PASSWORD_RESET) {
            return response()->json(['message' => __($status)], 200);
        } else {
            throw ValidationException::withMessages([
                'email' => __($status)
            ]);
        }
    }


    public function deleteUser(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        $request->user()->delete();
        $request->user()->update([
            'status' => 'deleted'
        ]);
        return response()->json(['data' => 'your Account Deleted Successfully'],'200');
    }

}
