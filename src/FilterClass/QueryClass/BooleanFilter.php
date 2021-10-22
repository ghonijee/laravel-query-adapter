<?php

namespace GhoniJee\DxAdapter\FilterClass\QueryClass;

use Exception;

class BooleanFilter
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

    public function andCondition()
    {
        switch ($this->value) {
            case true:
                $this->query->where($this->filterData->field, '=', true);
                break;
            case false:
                $this->query->where($this->field, '=', false);
                break;
            default:
                throw new Exception("Error Processing Request");
                break;
        }
    }

    public function orCondition()
    {
        switch ($this->value) {
            case true:
                $this->query->orWhere($this->filterData->field, '=', true);
                break;
            case false:
                $this->query->orWhere($this->field, '=', false);
                break;
            default:
                throw new Exception("Error Processing Request");
                break;
        }
    }

    public function notCondition()
    {
        switch ($this->value) {
            case true:
                $this->query->where($this->filterData->field, '!=', true);
                break;
            case false:
                $this->query->where($this->field, '!=', false);
                break;
            default:
                throw new Exception("Error Processing Request");
                break;
        }
    }
}
