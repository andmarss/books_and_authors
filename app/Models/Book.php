<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Book
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $text
 * @property int $category_id
 * @property int $author_id
 * @property string|null $image
 * @property string $status
 *
 * @property bool $is_in_progress
 * @property bool $is_finished
 * @property bool $is_cancelled
 *
 * @property BelongsTo|BookCategory $category
 * @property BelongsTo|User $author
 */
class Book extends Model
{
    use HasFactory;

    /** @var string $table */
    protected $table = 'books';

    /** @var string $primaryKey */
    protected $primaryKey = 'id';

    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_FINISHED = 'finished';
    const STATUS_CANCELLED = 'cancelled';

    /** @var array $fillable */
    protected $fillable = [
        'title',
        'author_id',
        'category_id',
        'description',
        'text',
        'image',
        'status'
    ];
    /** @var array $appends */
    protected $appends = [
        'is_in_progress',
        'is_finished',
        'is_cancelled'
    ];

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BookCategory::class, 'category_id', 'id');
    }

    /**
     * @return bool
     */
    public function getIsInProgressAttribute(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    /**
     * @return bool
     */
    public function getIsFinishedAttribute(): bool
    {
        return $this->status === self::STATUS_FINISHED;
    }

    /**
     * @return bool
     */
    public function getIsCancelledAttribute(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }
}
