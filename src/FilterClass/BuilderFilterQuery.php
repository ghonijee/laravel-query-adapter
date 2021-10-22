<?php

namespace GhoniJee\DxAdapter\FilterClass;

use GhoniJee\DxAdapter\Data\FilterData;
use GhoniJee\DxAdapter\Enums\ValueDataType;
use GhoniJee\DxAdapter\FilterClass\QueryClass\BooleanFilter;
use GhoniJee\DxAdapter\FilterClass\QueryClass\DateFilter;
use GhoniJee\DxAdapter\FilterClass\QueryClass\NumericFilter;
use GhoniJee\DxAdapter\FilterClass\QueryClass\StringFilter;

class BuilderFilterQuery
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

    public static function fromDataType($query, FilterData $filterData, $conjungtion)
    {
        return new self($query, $filterData, $conjungtion);
    }

    public function query()
    {
        switch ($this->filterData->type) {
            case ValueDataType::ISDATE:
                return DateFilter::build($this->query, $this->filterData, $this->conjungtion);
                break;
            case ValueDataType::ISNUMERIC:
                return NumericFilter::build($this->query, $this->filterData, $this->conjungtion);
                break;
            case ValueDataType::ISSTRING:
                return StringFilter::build($this->query, $this->filterData, $this->conjungtion);
                break;
            case ValueDataType::ISBOOLEAN:
                return BooleanFilter::build($this->query, $this->filterData, $this->conjungtion);
                break;
        }
    }
}
