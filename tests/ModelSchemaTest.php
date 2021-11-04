<?php

namespace Nicolasalexandre9\LaravelAppSchema\Tests;

use Illuminate\Support\Collection;
use Nicolasalexandre9\LaravelAppSchema\Schema\ModelSchema;
use Nicolasalexandre9\LaravelAppSchema\Tests\Models\Category;

/**
 * Class ModelSchemaTest
 *
 * @category Laravel-app-schema
 * @package  Laravel-app-schema
 * @author   nicolas <nicolasalexandre9@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 */
class ModelSchemaTest extends TestCase
{
    /**
     * @return void
     * @throws \ReflectionException
     * @throws \Doctrine\DBAL\Exception
     */
    public function test_get_attributes(): void
    {
        $model = new Category();
        $modelSchema = new ModelSchema($model);
        $result = $modelSchema->getAttributes();
        $columns = $model->getConnection()
            ->getDoctrineSchemaManager()
            ->listTableColumns($model->getConnection()->getTablePrefix() . $model->getTable());

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertTrue($result->has(array_keys($columns)));
    }

    /**
     * @throws \ReflectionException
     */
    public function test_get_relationships(): void
    {
        $model = new Category();
        $modelSchema = new ModelSchema($model);
        $result = $modelSchema->getRelationships();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertTrue($result->isNotEmpty());
        $this->assertIsArray($result->first());
        $this->assertArrayHasKey('type', $result->first());
        $this->assertArrayHasKey('method', $result->first());
        $this->assertArrayHasKey('class', $result->first());
    }

    /**
     * @throws \ReflectionException
     * @throws \Doctrine\DBAL\Exception
     */
    public function test_get_schema(): void
    {
        $model = new Category();
        $modelSchema = (new ModelSchema($model))->createSchema();
        $result = $modelSchema->getSchema();

        $this->assertInstanceOf(ModelSchema::class, $modelSchema);
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertTrue($result->has(['class', 'attributes', 'relationships', 'table']));
    }
}
