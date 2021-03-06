<?php

namespace GhoniJee\DxAdapter\FilterClass\QueryClass;

use GhoniJee\DxAdapter\Data\FilterData;
use Illuminate\Database\Eloquent\Builder;

class BooleanFilter
{
    protected Builder $query;
    protected FilterData $filterData;
    protected $conjungtion;

    public function __construct(Builder $query, FilterData $filterData, $conjungtion)
    {
        $this->query = $query;
        $this->filterData = $filterData;
        $this->conjungtion = $conjungtion;
    }

    public static function build($query, $filterData, $conjungtion)
    {
        $instance = new self($query, $filterData, $conjungtion);
        return $instance->get();
    }

    public function get()
    {
        switch ($this->conjungtion) {
            case '!':
                $this->query->where($this->filterData->field, '!=', $this->filterData->value);
                break;
            case 'or':
                $this->query->orWhere($this->filterData->field, '=', $this->filterData->value);
                break;
            default:
                $this->query->where($this->filterData->field, '=', $this->filterData->value);
                break;
        }
        return $this->query;
    }
}
