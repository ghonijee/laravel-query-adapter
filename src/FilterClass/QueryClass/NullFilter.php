<?php

namespace GhoniJee\DxAdapter\FilterClass\QueryClass;

use GhoniJee\DxAdapter\Data\FilterData;
use Illuminate\Database\Eloquent\Builder;

class NullFilter
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
                $this->query->whereNotNull($this->filterData->field);
                break;
            case 'or':
                if ($this->filterData->condition == '!=') {
                    $this->query->orWhereNotNull($this->filterData->field);
                } else {
                    $this->query->orWhereNull($this->filterData->field);
                }
                break;
            default:
                if ($this->filterData->condition == '!=') {
                    $this->query->whereNotNull($this->filterData->field);
                } else {
                    $this->query->whereNull($this->filterData->field);
                }
                break;
        }
        return $this->query;
    }
}
