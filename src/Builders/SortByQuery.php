<?php

namespace GhoniJee\DxAdapter\Builders;

use GhoniJee\DxAdapter\Data\SortData;
use GhoniJee\DxAdapter\SortClass\BuilderSortData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
            $this->query->orderBy($item->field, $item->type);
        });
    }
}
