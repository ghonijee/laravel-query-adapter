<?php

namespace GhoniJee\DxAdapter\FilterClass\QueryClass;

use Exception;

class NumericFilter
{
    protected $query;
    protected $filterData;
    protected $conjungtion;

    public function __construct($query, $filterData, $conjungtion)
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
                $this->query->whereNot($this->filterData->field, $this->filterData->condition, $this->filterData->value);
                break;
            case 'or':
                $this->query->orWhere($this->filterData->field, $this->filterData->condition, $this->filterData->value);
                break;
            default:
                $this->query->where($this->filterData->field, $this->filterData->condition, $this->filterData->value);
                break;
        }
        return $this->query;
    }
}
