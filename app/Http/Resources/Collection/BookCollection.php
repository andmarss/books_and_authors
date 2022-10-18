<?php

namespace App\Http\Resources\Collection;

use App\Http\Resources\BookResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookCollection extends ResourceCollection
{
    public $collects = BookResource::class;
}
