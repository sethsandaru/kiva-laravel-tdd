<?php

namespace App\Models;

use App\Services\Traits\EloquentBuilderMixin;
use App\Services\Traits\HasUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class Note
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property string $title
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property User $user
 * @property Collection|NoteContent[] $contents
 * @mixin EloquentBuilderMixin
 */
class Note extends Model
{
    use SoftDeletes, HasUuid, HasFactory;

    protected $table = 'notes';

    protected $casts = [
        'user_id' => 'int',
    ];

    protected $fillable = [
        'user_id',
        'title',
    ];

    /**
     * A note belongs to an User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A note has many contents (history-purpose)
     *
     * @return HasMany
     */
    public function contents(): HasMany
    {
        return $this->hasMany(NoteContent::class, 'note_id');
    }
}
