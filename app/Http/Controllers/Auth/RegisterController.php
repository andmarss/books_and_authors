<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserTokenResource;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(StoreUserRequest $request)
    {
        try {
            /** @var User $user */
            $user = User::query()->create($request->validated());

            $this->guard()->login($user);

            return (new UserTokenResource($user))
                ->response($request)
                ->setStatusCode(201);

        } catch (\Exception $exception) {
            Log::error(
                sprintf("Ошибка регистрации нового пользователя%s%s%s(%s) %s%s%s", PHP_EOL, PHP_EOL, $exception->getFile(), $exception->getLine(), $exception->getMessage(), PHP_EOL, $exception->getTraceAsString())
            );

            return response()->json(['error' => "Произошла ошибка при регистрации пользователя."], 500);
        }
    }
}
