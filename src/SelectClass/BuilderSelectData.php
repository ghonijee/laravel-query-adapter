<?php

namespace GhoniJee\DxAdapter\SelectClass;

use GhoniJee\DxAdapter\Data\RelationSelectData;
use GhoniJee\DxAdapter\Data\SelectData;
use Illuminate\Support\Collection;

class BuilderSelectData
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
        return $instance;
    }

    public function build()
    {
        $this->data = $this->data->map(function (string $item) {
            return SelectData::fromRequest($item);
        });
    }

    public function all()
    {
        return $this->data->map(function (SelectData $item) {
            return $item->field;
        })->toArray();
    }

    public function noRealtion()
    {
        return $this->data->filter(function (SelectData $item) {
            return !$item->isRelation;
        })->pluck('field')->toArray();
    }

    public function relation()
    {
        $relationSelect = $this->data->filter(function (SelectData $item) {
            return $item->isRelation;
        });
        $grouped = $relationSelect->groupBy(function (SelectData $item) {
            return $item->relation;
        });
        return $grouped->map(function (Collection $selectField, string $relationField) {
            return RelationSelectData::build($relationField, $selectField);
        });
    }
}
