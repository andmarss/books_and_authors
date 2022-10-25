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
 * @property int $category_id
 * @property int $author_id
 *
 * @property bool $is_in_progress
 * @property bool $is_finished
 * @property bool $is_cancelled
 * @property string $status_title
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
            'id'             => $this->id,
            'title'          => $this->title,
            'description'    => $this->description,
            'text'           =>  $this->text,
            'image'          => $this->image,
            'status'         => $this->status,
            'status_title'   => $this->status_title,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
            'is_in_progress' => $this->is_in_progress,
            'is_finished'    => $this->is_finished,
            'is_cancelled'   => $this->is_cancelled,
            'category_id'    => $this->category_id,
            'author_id'      => $this->author_id,
            'category'       => (new \App\Http\Resources\BookCategoryCleanResource($this->category))->toArray($request),
            'author'         => (new \App\Http\Resources\UserResourceClean($this->author))->toArray($request),
        ];
    }
}
