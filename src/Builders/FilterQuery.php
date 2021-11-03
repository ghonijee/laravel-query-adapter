<?php

namespace GhoniJee\DxAdapter\Builders;

use GhoniJee\DxAdapter\Data\FilterData;
use GhoniJee\DxAdapter\FilterClass\BuilderFilterData;
use GhoniJee\DxAdapter\FilterClass\BuilderFilterQuery;
use GhoniJee\DxAdapter\FilterClass\BuilderRelationFilterQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait FilterQuery
{
    protected function parseFilter()
    {
        $keyRequest = config('dx-adapter.request.filter');

        $this->filter = $this->serializeData($keyRequest);

        $this->setArray();

        $this->buildFilterData();

        $this->query = $this->buildFilterQuery($this->query, $this->filter);

        return $this;
    }

    private function setArray()
    {
        if (is_string($this->filter[0])) {
            $this->filter = collect([$this->filter]);
        }
    }

    private function buildFilterData()
    {
        $this->filter = BuilderFilterData::fromRequest($this->filter);
    }

    private function buildFilterQuery(Builder $query, $collection)
    {
        $collection->each(function ($item) use ($query) {
            if (is_string($item)) {
                $this->conjungtion = $item;
                return true;
            }

            if ($item instanceof Collection) {
                $this->query->where(function ($subQuery) use ($item) {
                    $subQuery = $this->buildFilterQuery($subQuery, $item);
                });
                return true;
            }

            if ($this->isRelationFilter($query, $item)) {
                $this->query = BuilderRelationFilterQuery::fromDataType($this->query, $item, $this->conjungtion)->query();
                return true;
            }

            $query = BuilderFilterQuery::fromDataType($query, $item, $this->conjungtion)->query();
        });

        return $query;
    }

    private function isRelationFilter(Builder $query, FilterData $item)
    {
        if (!$item->isRelation) {
            return false;
        }

        if (!method_exists($query->getModel(), $item->relationMethod)) {
            return false;
        }

        return is_a($query->getModel()->{$item->relationMethod}(), Relation::class);
    }
}
