<?php

namespace Nicolasalexandre9\LaravelAppSchema\Tests;

use Illuminate\Support\Collection;
use Nicolasalexandre9\LaravelAppSchema\Tests\Models\Category;
use Nicolasalexandre9\LaravelAppSchema\Tests\Models\Comment;
use Nicolasalexandre9\LaravelAppSchema\Tests\Models\Post;
use Nicolasalexandre9\LaravelAppSchema\Schema\AppSchema;

/**
 * Class AppSchemaTest
 *
 * @category Laravel-app-schema
 * @package  Laravel-app-schema
 * @author   nicolas <nicolasalexandre9@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 */
class AppSchemaTest extends TestCase
{
    /**
     * @return void
     */
    public function test_is_model_valid(): void
    {
        $result = AppSchema::isModel(Post::class);

        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function test_extract_class_valid(): void
    {
        $post = new Post();
        $fileContent = file_get_contents((new \ReflectionClass($post))->getFileName());
        $result = AppSchema::extractClass($fileContent);

        $this->assertEquals(get_class($post), $result);
    }

    /**
     * @return void
     */
    public function test_get_models_valid(): void
    {
        $appSchema = new AppSchema();
        $result = $appSchema->getModels();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertTrue($result->contains(get_class((new post()))));
        $this->assertTrue($result->contains(get_class((new category()))));
        $this->assertTrue($result->contains(get_class((new comment()))));
    }

    /**
     * @return void
     * @throws \Doctrine\DBAL\Exception
     * @throws \ReflectionException
     */
    public function test_create_schema_valid(): void
    {
        $appSchema = new AppSchema();
        $appSchema->createSchema();

        $this->assertFileExists(config('schema.schema_file_path'));
    }
}
