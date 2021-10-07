<?php

namespace Floo\DxAdapter\FilterClass;

use Floo\DxAdapter\Data\FilterData;
use Floo\DxAdapter\Enums\ValueDataType;
use Illuminate\Database\Eloquent\Builder;

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
                break;
            case ValueDataType::ISSTRING:
                return StringFilter::build($this->query, $this->filterData, $this->conjungtion);
                break;
        }
    }
}
