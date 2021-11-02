<?php

namespace GhoniJee\DxAdapter\FilterClass;

use Exception;
use GhoniJee\DxAdapter\Data\FilterData;
use GhoniJee\DxAdapter\Enums\ValueDataType;
use GhoniJee\DxAdapter\FilterClass\QueryClass\BooleanFilter;
use GhoniJee\DxAdapter\FilterClass\QueryClass\DateFilter;
use GhoniJee\DxAdapter\FilterClass\QueryClass\NullFilter;
use GhoniJee\DxAdapter\FilterClass\QueryClass\NumericFilter;
use GhoniJee\DxAdapter\FilterClass\QueryClass\StringFilter;

class BuilderRelationFilterQuery
{
    protected $query;

    protected FilterData $filterData;

    protected $conjungtion;

    public function __construct($query, FilterData $filterData, $conjungtion)
    {
        $this->query = $query;
        $this->filterData = $filterData;
        $this->conjungtion = $conjungtion;
    }

    public static function fromDataType($query, FilterData $filterData, $conjungtion = null)
    {
        return new self($query, $filterData, $conjungtion);
    }

    public function query()
    {
        switch ($this->conjungtion) {
            case '!':
                $this->query->whereDoesntHave($this->filterData->relationMethod, function ($relationQuery) {
                    $relationQuery = BuilderFilterQuery::fromDataType($relationQuery, $this->filterData)->query();
                });
                break;
            case 'or':
                $this->query->orWhereHas($this->filterData->relationMethod, function ($relationQuery) {
                    $relationQuery = BuilderFilterQuery::fromDataType($relationQuery, $this->filterData)->query();
                });
                break;
            default:
                $this->query->whereHas($this->filterData->relationMethod, function ($relationQuery) {
                    $relationQuery = BuilderFilterQuery::fromDataType($relationQuery, $this->filterData)->query();
                });
                break;
        }
        return $this->query;
    }
}
