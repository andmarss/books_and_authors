<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 *
 * @property Collection $books
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return array_merge((new UserResourceClean($this))->toArray($request), [
            'books' => BookResource::collection($this->books)->toArray($request)
        ]);
    }
}
