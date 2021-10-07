<?php

namespace Floo\DxAdapter\Builders;

use Floo\DxAdapter\Data\FilterData;
use Floo\DxAdapter\FilterClass\BuilderFilterData;
use Floo\DxAdapter\FilterClass\BuilderFilterQuery;

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

        $this->buildQuery();

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

    private function buildQuery()
    {
        $this->filter->each(function ($item) {
            if ($item instanceof FilterData === false) {
                $this->conjungtion = $item;
                return true;
            }
            $this->query = BuilderFilterQuery::fromDataType($this->query, $item, $this->conjungtion)->query();
        });
    }
}
