<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * Class BookCategoryResource
 *
 * @property Collection $books
 */
class BookCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return array_merge((new BookCategoryCleanResource($this))->toArray($request), [
            'books' => BookResource::collection($this->books)
        ]);
    }
}
