<?php

namespace Nicolasalexandre9\LaravelAppSchema\Schema;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionMethod;

/**
 * Class ModelSchema
 *
 * @category Laravel-app-schema
 * @package  Laravel-app-schema
 * @author   nicolas <nicolasalexandre9@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 */
class ModelSchema
{
    /**
     * @var Collection
     */
    private Collection $schema;

    /**
     * @var Model
     */
    private Model $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->schema = collect();
    }

    /**
     * @return ModelSchema
     * @throws \Doctrine\DBAL\Exception
     */
    public function createSchema(): self
    {
        $this->schema->put('class', get_class($this->model));
        $this->schema->put('table', $this->model->getTable());
        $this->schema->put('attributes', $this->getAttributes());
        $this->schema->put('relationships', $this->getRelationships());

        return $this;
    }

    /**
     * @return Collection
     * @throws \Doctrine\DBAL\Exception
     */
    public function getAttributes(): Collection
    {
        $attributes = collect();
        $columns = $this->model
            ->getConnection()
            ->getDoctrineSchemaManager()
            ->listTableColumns($this->model->getTable());

        foreach ($columns as $column) {
            $attributes->put(
                $column->getName(),
                [
                    'autoIncrement' => $column->getAutoincrement(),
                    'type'          => $column->getType()->getName(),
                    'nullable'      => !$column->getNotnull(),
                    'length'        => $column->getLength(),
                ]
            );
        }

        return $attributes;
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \ReflectionException
     */
    public function getRelationships(): Collection
    {
        $relationships = collect();
        $methods = (new ReflectionClass($this->model))->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            if ($method->class !== get_class($this->model) ||
                !empty($method->getParameters())
            ) {
                continue;
            }

            $returnType = $method->getReturnType();
            if ($returnType && $returnType->getName() && class_exists($returnType->getName())) {
                $reflection = new \ReflectionClass($returnType->getName());
                if ($reflection->isSubclassOf(Relation::class)) {
                    $return = $method->invoke($this->model);
                    $relationships->push(
                        [
                            'type'    => $reflection->getShortName(),
                            'method' => $method->getName(),
                            'class'   => (new ReflectionClass($return->getRelated()))->getName(),
                        ]
                    );
                }
            }
        }

        return $relationships;
    }


    /**
     * @return Collection
     */
    public function getSchema(): Collection
    {
        return $this->schema;
    }
}
