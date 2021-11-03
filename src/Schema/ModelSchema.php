<?php

namespace Nicolasalexandre9\LaravelAppSchema\Schema;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
        $this->schema->put('attributes', $this->getAttributes());

        return $this;
    }

    /**
     * @return Collection
     * @throws \Doctrine\DBAL\Exception
     */
    private function getAttributes(): Collection
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
     * @return Collection
     */
    public function getSchema(): Collection
    {
        return $this->schema;
    }
}
