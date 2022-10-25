<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserTokenResource;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(UserLoginRequest $request)
    {
        if (auth()->attempt($request->only([$this->username(), 'password']))) {
            /** @var User $user */
            $user = auth()->user();

            return (new UserTokenResource($user))->response($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $token_ids = $user->tokens->pluck('id');
            Token::query()->whereIn('id', $token_ids)->update(['revoked' => true]);
            RefreshToken::query()->whereIn('access_token_id', $token_ids)->update(['revoked' => true]);

            return response()->json(['message' => 'Logged out'], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function username()
    {
        return 'pseudonym';
    }
}
