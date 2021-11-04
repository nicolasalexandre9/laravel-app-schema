<?php

namespace Nicolasalexandre9\LaravelAppSchema\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Post
 *
 * @category Laravel-app-schema
 * @package  Laravel-app-schema
 * @author   nicolas <nicolasalexandre9@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 */
class Post extends Model
{
    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(category::class);
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
