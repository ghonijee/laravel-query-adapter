<?php

namespace Floo\DxAdapter\FilterClass;

use Floo\DxAdapter\Data\FilterData;

class BuilderFilterData
{
    /**
     *  @var Collection $data
     */
    public $data;

    public function __construct($data)
    {
        $this->data = collect($data);
    }

    public static function fromRequest($data)
    {
        $instance = new self($data);
        $instance->build();
        return $instance->data;
    }

    public function build()
    {
        $this->data = $this->data->map(function ($item) {
            if ($this->isConjungtion($item)) {
                return $item;
            }

            if ($this->isMultidimensi($item)) {
                $instance = new self($item);
                $instance->build();
                return $instance->data;
            }
            return FilterData::fromRequest($item);
        });
    }

    public function isConjungtion($item): bool
    {
        if (!is_array($item)) {
            return true;
        }
        return false;
    }

    public function isMultidimensi($item): bool
    {
        return count($item) !== count($item, COUNT_RECURSIVE);
    }
}
