<?php

namespace App\Models;

use App\Services\Traits\HasUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Image
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property string $filename
 * @property string $url
 * @property string $service
 * @property array $payload
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 */
class Image extends Model
{
    use HasUuid;

    protected $table = 'images';

    /**
     * A note belongs to an User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
