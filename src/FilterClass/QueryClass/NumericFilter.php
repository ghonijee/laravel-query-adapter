<?php

namespace Floo\DxAdapter\FilterClass\QueryClass;

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
                $this->notCondition();
                break;
            case 'or':
                $this->orCondition();
                break;
            default:
                $this->andCondition();
                break;
        }
        return $this->query;
    }

    protected function notCondition()
    {
        switch ($this->filterData->condition) {
            case '=':
                $this->query->where($this->filterData->field, '<>', $this->filterData->value);
                break;
            case '<':
                $this->query->where($this->filterData->field, '>', $this->filterData->value);
                break;
            case '<=':
                $this->query->where($this->filterData->field, '>=', $this->filterData->value);
                break;
            case '>':
                $this->query->where($this->filterData->field, '<', $this->filterData->value);
                break;
            case '>=':
                $this->query->where($this->filterData->field, '<=', $this->filterData->value);
                break;
            default:
                throw new Exception("Error Processing Request");
                break;
        }
    }

    protected function orCondition()
    {

        switch ($this->filterData->condition) {
            case '=':
                $this->query->orWhere($this->filterData->field, '=', $this->filterData->value);
                break;
            case '<':
                $this->query->orWhere($this->filterData->field, '<', $this->filterData->value);
                break;
            case '<=':
                $this->query->orWhere($this->filterData->field, '<=', $this->filterData->value);
                break;
            case '>':
                $this->query->orWhere($this->filterData->field, '>', $this->filterData->value);
                break;
            case '>=':
                $this->query->orWhere($this->filterData->field, '>=', $this->filterData->value);
                break;
            default:
                throw new Exception("Error Processing Request");
                break;
        }
    }

    protected function andCondition()
    {
        switch ($this->filterData->condition) {
            case '=':
                $this->query->where($this->filterData->field, '=', $this->filterData->value);
                break;
            case '<':
                $this->query->where($this->filterData->field, '<', $this->filterData->value);
                break;
            case '<=':
                $this->query->where($this->filterData->field, '<=', $this->filterData->value);
                break;
            case '>':
                $this->query->where($this->filterData->field, '>', $this->filterData->value);
                break;
            case '>=':
                $this->query->where($this->filterData->field, '>=', $this->filterData->value);
                break;
            default:
                throw new Exception("Error Processing Request");
                break;
        }
    }
}
