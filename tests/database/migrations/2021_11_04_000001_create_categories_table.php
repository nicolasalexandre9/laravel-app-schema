<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateCategoriesTable
 *
 * @category Laravel-app-schema
 * @package  Laravel-app-schema
 * @author   nicolas <nicolasalexandre9@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 */
class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->timestamps();
        });
    }
}
