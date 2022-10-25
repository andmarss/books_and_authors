<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResourceClean
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $pseudonym
 * @property string $full_name
 */
class UserResourceClean extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'full_name' => $this->full_name,
            'books_count' => $this->books()->count(),
            $this->mergeWhen($user && $this->id === $user->id, [
                'pseudonym' => $this->pseudonym
            ]),
        ];
    }
}
