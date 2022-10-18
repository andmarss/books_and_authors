<?php

namespace App\Http\Resources;

use App\Models\BookCategory;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class BookResource
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $image
 * @property string $status
 * @property string $updated_at
 *
 * @property bool $is_in_progress
 * @property bool $is_finished
 * @property bool $is_cancelled
 *
 * @property BookCategoryResource $category
 * @property User $author
 */
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'text'        =>  $this->text,
            'image'       => $this->image,
            'status'      => $this->status,
            'updated_at'  => $this->updated_at,
            'is_in_progress' => $this->is_in_progress,
            'is_finished'    => $this->is_finished,
            'is_cancelled'   => $this->is_cancelled,
            'category'    => new \App\Http\Resources\BookCategoryResource($this->category),
            'author' => new \App\Http\Resources\UserResourceClean($this->author)
        ];
    }
}
