<?php

namespace GhoniJee\DxAdapter\Builders;

use GhoniJee\DxAdapter\Data\RelationSelectData;
use GhoniJee\DxAdapter\Data\SelectData;
use GhoniJee\DxAdapter\SelectClass\BuilderSelectData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait SelectQuery
{
    protected function parseSelect()
    {
        $keyRequest = config('dx-adapter.request.select');

        $this->select = $this->serializeData($keyRequest);

        $this->buildRealationSelectQuery();

        $this->buildSelectQuery();

        return $this;
    }

    protected function buildRealationSelectQuery()
    {
        $this->relationSelect = BuilderSelectData::fromRequest($this->select)->relation();

        $this->relationSelect->each(function (RelationSelectData $item) {
            if ($this->isRelationSelectValid($this->query, $item) == false) {

                return true; //for skip each
            }
            $fieldSelected = $item->field->pluck('field')->toArray();
            $this->query->with([$item->relation => function ($querySelect) use ($fieldSelected) {
                $querySelect->select($fieldSelected);
            }]);
        });
    }
    protected function buildSelectQuery()
    {
        $this->select = BuilderSelectData::fromRequest($this->select)->noRealtion();

        $this->query->select($this->select);
    }

    private function isRelationSelectValid(Builder $query, RelationSelectData $item)
    {
        if (!method_exists($query->getModel(), $item->relation)) {
            return false;
        }

        return is_a($query->getModel()->{$item->relation}(), Relation::class);
    }
}
