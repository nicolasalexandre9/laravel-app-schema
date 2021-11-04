<?php

namespace Nicolasalexandre9\LaravelAppSchema\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Category
 *
 * @category Laravel-app-schema
 * @package  Laravel-app-schema
 * @author   nicolas <nicolasalexandre9@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 */
class Category extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
