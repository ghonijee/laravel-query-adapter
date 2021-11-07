<?php

namespace GhoniJee\DxAdapter\FilterClass\QueryClass;

use Exception;

class StringFilter
{
    protected $query;
    protected $filterData;
    protected $conjungtion;
    protected $contains;

    public function __construct($query, $filterData, $conjungtion)
    {
        $this->query = $query;
        $this->filterData = $filterData;
        $this->conjungtion = $conjungtion;
        $this->contains = config('dx-adapter.query.contains') ?: "like";
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
            case 'contains':
                $this->query->orWhere($this->filterData->field, "not $this->contains", "%{$this->filterData->value}%");
                break;
            case 'notcontains':
                $this->query->orWhere($this->filterData->field, "$this->contains", "%{$this->filterData->value}%");
                break;
            case 'startswith':
                $this->query->orWhere($this->filterData->field, "not $this->contains", "{$this->filterData->value}%");
                break;
            case 'endswith':
                $this->query->orWhere($this->filterData->field, "not $this->contains", "%{$this->filterData->value}");
                break;
            case '=':
                $this->query->whereNot($this->filterData->field, $this->filterData->value);
                break;
            default:
                $this->query->whereNot($this->filterData->field, $this->filterData->condition, $this->filterData->value);
                break;
        }
    }

    protected function orCondition()
    {
        switch ($this->filterData->condition) {
            case 'contains':
                $this->query->orWhere($this->filterData->field, "$this->contains", "%{$this->filterData->value}%");
                break;
            case 'notcontains':
                $this->query->orWhere($this->filterData->field, "not $this->contains", "%{$this->filterData->value}%");
                break;
            case 'startswith':
                $this->query->orWhere($this->filterData->field, "$this->contains", "{$this->filterData->value}%");
                break;
            case 'endswith':
                $this->query->orWhere($this->filterData->field, "$this->contains", "%{$this->filterData->value}");
                break;
            case '=':
                $this->query->orWhere($this->filterData->field, $this->filterData->value);
                break;
            default:
                $this->query->where($this->filterData->field, $this->filterData->condition, $this->filterData->value);
        }
    }

    protected function andCondition()
    {
        switch ($this->filterData->condition) {
            case 'contains':
                $this->query->where($this->filterData->field, "$this->contains", "%{$this->filterData->value}%");
                break;
            case 'notcontains':
                $this->query->where($this->filterData->field, "not $this->contains", "%{$this->filterData->value}%");
                break;
            case 'startswith':
                $this->query->where($this->filterData->field, "$this->contains", "{$this->filterData->value}%");
                break;
            case 'endswith':
                $this->query->where($this->filterData->field, "$this->contains", "%{$this->filterData->value}");
                break;
            case '=':
                $this->query->where($this->filterData->field, $this->filterData->value);
                break;
            default:
                $this->query->where($this->filterData->field, $this->filterData->condition, $this->filterData->value);
                break;
        }
    }
}
