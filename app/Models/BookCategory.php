<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class BookCategory
 *
 * @property int $id
 * @property string $name
 * @property string $description
 *
 * @property HasMany|Book[]|Collection $books
 */
class BookCategory extends Model
{
    use HasFactory;

    /** @var string $table */
    protected $table = 'book_categories';

    /** @var string $primaryKey */
    protected $primaryKey = 'id';

    /** @var array $fillable */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * @return HasMany
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'category_id', 'id');
    }
}
