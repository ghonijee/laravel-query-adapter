<?php

namespace GhoniJee\DxAdapter\SortClass;

use GhoniJee\DxAdapter\Data\SortData;
use Illuminate\Support\Collection;

class BuilderSortData
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
            return SortData::fromRequest($item);
        });
    }
}
