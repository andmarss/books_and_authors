<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        /**
         * @var \Illuminate\Database\Eloquent\Builder $query
         */
        $query = User::query();

        $query->when($request->input('name'), function (\Illuminate\Database\Eloquent\Builder $query, $name) {
            $query->where('first_name', 'like', '%' . $name . '%')
                ->orWhere('last_name', 'like', '%' . $name . '%')
                ->orWhere('middle_name', 'like', '%' . $name . '%')
                ->orWhere('pseudonym', 'like', '%' . $name . '%')
                ->orWhereRaw("CONCAT(last_name, first_name) LIKE '%" . trim(strval($name)) . "%'")
                ->orWhereRaw("CONCAT(last_name, first_name, middle_name) LIKE '%" . trim(strval($name)) . "%'");
        });

        /**
         * @var \Illuminate\Database\Eloquent\Collection $users
         */
        $users = $query->with(['books'])
            ->forPage($request->input('page', 1), $request->input('per_page', 10))
            ->withCount('books')
            ->orderBy('books_count', 'desc')
            ->get();

        return UserResource::collection($users)->response($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return response()->json(['success' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        try {
            /** @var User $user */
            $user = User::query()->create($request->validated());

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Пользователь не был создан'
                ], 400);
            }

            return (new UserResource($user))
                ->response($request)
                ->setStatusCode(201);

        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        /** @var User|null $user */
        $user = User::query()->with(['books'])->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь не найден'
            ], 404);
        }

        return (new UserResource($user))->response($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $id)
    {
        $user = User::query()->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь не найден'
            ], 404);
        }
        /** @var User $requestedUser */
        $requestedUser = $request->user();

        if (!$requestedUser) {
            throw new AuthenticationException();
        }

        if ($requestedUser->id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Нет прав для редактирования'
            ], 403);
        }

        return (new UserResource($user))->response($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
