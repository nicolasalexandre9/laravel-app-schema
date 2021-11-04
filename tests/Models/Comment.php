<?php

namespace Nicolasalexandre9\LaravelAppSchema\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Comment
 *
 * @category Laravel-app-schema
 * @package  Laravel-app-schema
 * @author   nicolas <nicolasalexandre9@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 */
class Comment extends Model
{
    /**
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
