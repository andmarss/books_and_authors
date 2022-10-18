<?php

namespace App\Http\Resources\Collection;

use App\Http\Resources\BookCategoryResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookCategoryCollection extends ResourceCollection
{
    public $collects = BookCategoryResource::class;
}
