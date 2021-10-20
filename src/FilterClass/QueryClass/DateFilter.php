<?php

namespace Floo\DxAdapter\FilterClass\QueryClass;

use Carbon\Carbon;
use Exception;

class DateFilter
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
                $this->query->where($this->filterData->field, '!=', $this->filterData->value);
                break;
            case '<':
                $this->query->whereDate($this->filterData->field, '>', Carbon::parse($this->filterData->value)->addDay(1));
                break;
            case '<=':
                $this->query->whereDate($this->filterData->field, '>=', Carbon::parse($this->filterData->value)->addDay(1));
                break;
            case '>':
                $this->query->whereDate($this->filterData->field, '<', Carbon::parse($this->filterData->value)->addDay(1));
                break;
            case '>=':
                $this->query->whereDate($this->filterData->field, '<=', Carbon::parse($this->filterData->value)->addDay(1));
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
                $this->query->orWhereDate($this->filterData->field, '<', Carbon::parse($this->filterData->value)->addDay(1));
                break;
            case '<=':
                $this->query->orWhereDate($this->filterData->field, '<=', Carbon::parse($this->filterData->value)->addDay(1));
                break;
            case '>':
                $this->query->orWhereDate($this->filterData->field, '>', Carbon::parse($this->filterData->value)->addDay(1));
                break;
            case '>=':
                $this->query->orWhereDate($this->filterData->field, '>=', Carbon::parse($this->filterData->value)->addDay(1));
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
                $this->query->whereDate($this->filterData->field, '<', Carbon::parse($this->filterData->value)->addDay(1));
                break;
            case '<=':
                $this->query->whereDate($this->filterData->field, '<=', Carbon::parse($this->filterData->value)->addDay(1));
                break;
            case '>':
                $this->query->whereDate($this->filterData->field, '>', Carbon::parse($this->filterData->value)->addDay(1));
                break;
            case '>=':
                $this->query->whereDate($this->filterData->field, '>=', Carbon::parse($this->filterData->value)->addDay(1));
                break;
            default:
                throw new Exception("Error Processing Request");
                break;
        }
    }
}
