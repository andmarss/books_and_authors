<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class BookController extends Controller
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
        $query = Book::query();

        $query->when($request->input('title'), function ($query, $title) {
            $query->where('title', 'like', '%' . $title . '%');
        })->when($request->input('author_id'), function ($query, $author_id) {
            $query->where('author_id', $author_id);
        })->when($request->input('category_id'), function ($query, $category_id) {
            $query->where('category_id', $category_id);
        })->when($request->input('status'), function ($query, $status) {
            $query->where('status', $status);
        });

        $total = $query->count();

        $request->merge(['total' => $total]);

        /**
         * @var \Illuminate\Database\Eloquent\Collection $books
         */
        $books = $query->with(['author', 'category'])
            ->forPage($request->input('page', 1), $request->input('per_page', 10))
            ->orderBy($request->input('order_by', 'updated_at'), $request->input('order', 'desc'))
            ->get();

        return BookResource::collection($books)
            ->additional(['total' => $total])
            ->response($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        if (!$request->user()) throw new AuthenticationException();

        return response()->json(['success' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreBookRequest  $request
     * @return \Illuminate\Http\JsonResponse|BookResource
     */
    public function store(StoreBookRequest $request)
    {
        try {
            /** @var Book|null $book */
            $book = Book::query()->create($request->validated());

            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Книга не была создана'
                ], 400);
            }

            return (new BookResource($book))
                ->response($request)
                ->setStatusCode(201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        /** @var Book $book */
        $book = Book::query()->find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Книга не найдена'
            ], 404);
        }

        return (new BookResource($book))->response($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $id)
    {
        /** @var User $user */
        $user = $request->user();

        if (!$user) {
            throw new AuthenticationException();
        }

        /** @var Book $book */
        $book = Book::query()->find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Книга не найдена'
            ], 404);
        }

        if ($book->author_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Вы не можете редактировать эту книгу'
            ], 403);
        }

        return (new BookResource($book))->response($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBookRequest $request, $id)
    {
        /** @var User $user */
        $user = $request->user();

        /** @var Book $book */
        $book = Book::query()->find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Книга не найдена'
            ], 404);
        }

        if ($book->author_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Вы не можете редактировать эту книгу'
            ], 403);
        }

        $book->update($request->validated());

        return (new BookResource($book))->response($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        /** @var User $user */
        $user = $request->user();

        if (!$user) {
            throw new AuthenticationException();
        }

        /** @var Book $book */
        $book = Book::query()->find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Книга не найдена'
            ], 404);
        }

        if ($book->author_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Вы не можете удалить эту книгу'
            ], 403);
        }

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Книга успешно удалена'
        ]);
    }
}
