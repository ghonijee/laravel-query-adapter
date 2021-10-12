<?php

namespace Floo\DxAdapter\Builders;

use Floo\DxAdapter\Data\FilterData;
use Floo\DxAdapter\FilterClass\BuilderFilterData;
use Floo\DxAdapter\FilterClass\BuilderFilterQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait FilterQuery
{
    public $filter;

    public $conjungtion;

    protected function parseFilter()
    {
        $this->replaceSingleQuote();

        $this->serializeFilterData();

        $this->setArray();

        $this->buildFilterData();

        $this->query = $this->buildQuery($this->query, $this->filter);

        return $this;
    }

    private function replaceSingleQuote()
    {
        $this->filter = str_replace("'", '"', $this->request->filter);
    }

    private function serializeFilterData()
    {
        if (is_string($this->filter)) {
            $this->filter = json_decode($this->filter);
        }
    }

    private function setArray()
    {
        if (is_string($this->filter[0])) {
            $this->filter = [$this->filter];
        }
    }

    private function buildFilterData()
    {
        $this->filter = BuilderFilterData::fromRequest($this->filter);
    }

    private function buildQuery(Builder $query, $collection)
    {
        $collection->each(function ($item) use ($query) {
            if (is_string($item)) {
                $this->conjungtion = $item;
                return true;
            }

            if ($item instanceof Collection) {
                $this->query->where(function ($subQuery) use ($item) {
                    $subQuery = $this->buildQuery($subQuery, $item);
                });
                return true;
            }

            if ($this->isRelationFilter($query, $item)) {

                [$relation,] = collect(explode('.', $item->field))
                    ->pipe(function (Collection $parts) {
                        return [
                            $parts->except(count($parts) - 1)->implode('.'),
                            $parts->last(),
                        ];
                    });

                $this->query->whereHas($relation, function (Builder $relationQuery) use ($item) {
                    $relationQuery = BuilderFilterQuery::fromDataType($relationQuery, $item, $this->conjungtion)->query();
                });

                return true;
            }

            $query = BuilderFilterQuery::fromDataType($query, $item, $this->conjungtion)->query();
        });

        return $query;
    }

    private function isRelationFilter(Builder $query, FilterData $item)
    {
        if (!Str::contains($item->field, '.')) {
            return false;
        }

        $firstRelationship = explode('.', $item->field)[0];

        if (!method_exists($query->getModel(), $firstRelationship)) {
            return false;
        }

        return is_a($query->getModel()->{$firstRelationship}(), Relation::class);
    }
}
