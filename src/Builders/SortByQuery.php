<?php

namespace GhoniJee\DxAdapter\Builders;

use GhoniJee\DxAdapter\Data\SortData;
use GhoniJee\DxAdapter\SortClass\BuilderSortData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;

trait SortByQuery
{
    protected function applySort()
    {
        $keyRequest = config('dx-adapter.request.order');

        $this->sort = $this->serializeData($keyRequest);

        $this->toArray();

        $this->buildSortQuery();

        return $this;
    }

    private function toArray()
    {
        if (!isset($this->sort[0])) {
            $this->sort = [$this->sort];
        }
    }

    protected function buildSortQuery()
    {
        $this->sort = BuilderSortData::fromRequest($this->sort);

        $this->sort->each(function (SortData $item) {
            if ($item->isRelation) {
                if (!is_a($this->query->getModel()->{$item->relationMethod}(), Relation::class)) {
                    return true;
                }
                // Get Model instance
                $model = $this->query->getModel();

                // Get Relation Instance
                $relation = $model->{$item->relationMethod}();

                // Get TableName of Model Class
                $tableNameFrom = $model->getTable();

                // Get TableName of Relation Model
                $tableRelation = $relation->getRelated()->getTable();

                // Get Instance of Relation Target Model
                $relationModel = $relation->getRelated();

                // Add Order Query with SubQuery
                $this->query->orderBy(
                    $relationModel::select($item->field)
                        ->whereColumn($tableRelation . '.' . $relation->getOwnerKeyName(), $tableNameFrom . '.' . $relation->getForeignKeyName()) // targetTable , FromTable
                );
            } else {
                $this->query->orderBy($item->field, $item->type);
            }
        });
    }
}
