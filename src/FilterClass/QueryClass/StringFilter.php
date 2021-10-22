<?php

namespace GhoniJee\DxAdapter\FilterClass\QueryClass;

use Exception;

class StringFilter
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
            case 'contains':
                $this->query->orWhere($this->filterData->field, 'not like', "%{$this->filterData->value}%");
                break;
            case 'notcontains':
                $this->query->orWhere($this->filterData->field, 'like', "%{$this->filterData->value}%");
                break;
            case 'startswith':
                $this->query->orWhere($this->filterData->field, 'not like', "{$this->filterData->value}%");
                break;
            case 'endswith':
                $this->query->orWhere($this->filterData->field, 'not like', "%{$this->filterData->value}");
                break;
            case '=':
                $this->query->orWhere($this->filterData->field, '<>', "{$this->filterData->value}");
                break;
            case '<>':
                $this->query->orWhere($this->filterData->field, '=', "{$this->filterData->value}");
                break;
            default:
                throw new Exception("Error Processing Request");
                break;
        }
    }

    protected function orCondition()
    {
        switch ($this->filterData->condition) {
            case 'contains':
                $this->query->orWhere($this->filterData->field, 'like', "%{$this->filterData->value}%");
                break;
            case 'notcontains':
                $this->query->orWhere($this->filterData->field, 'not like', "%{$this->filterData->value}%");
                break;
            case 'startswith':
                $this->query->orWhere($this->filterData->field, 'like', "{$this->filterData->value}%");
                break;
            case 'endswith':
                $this->query->orWhere($this->filterData->field, 'like', "%{$this->filterData->value}");
                break;
            case '=':
                $this->query->orWhere($this->filterData->field, '=', "{$this->filterData->value}");
                break;
            case '<>':
                $this->query->orWhere($this->filterData->field, '<>', "{$this->filterData->value}");
                break;
            default:
                throw new Exception("Error Processing Request");
                break;
        }
    }

    protected function andCondition()
    {
        switch ($this->filterData->condition) {
            case 'contains':
                $this->query->where($this->filterData->field, 'like', "%{$this->filterData->value}%");
                break;
            case 'notcontains':
                $this->query->where($this->filterData->field, 'not like', "%{$this->filterData->value}%");
                break;
            case 'startswith':
                $this->query->where($this->filterData->field, 'like', "{$this->filterData->value}%");
                break;
            case 'endswith':
                $this->query->where($this->filterData->field, 'like', "%{$this->filterData->value}");
                break;
            case '=':
                if ($this->filterData->value == null) {
                    $this->query->where($this->filterData->field, NULL);
                } else {
                    $this->query->where($this->filterData->field, '=', "{$this->filterData->value}");
                }
                break;
            case '!=':
                if ($this->filterData->value == null) {
                    $this->query->whereNotNull($this->filterData->field);
                } else {
                    $this->query->where($this->filterData->field, '!=', "{$this->filterData->value}");
                }
                break;
            case '<>':
                $this->query->where($this->filterData->field, '<>', "{$this->filterData->value}");
                break;
            default:
                throw new Exception("Error Processing Request");
                break;
        }
    }
}
