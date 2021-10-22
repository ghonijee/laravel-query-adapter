<?php

namespace GhoniJee\DxAdapter\Data;

use Illuminate\Support\Str;

class SelectData
{
    public $field;

    public $relation;

    public $isRelation;

    public function __construct(string $field)
    {
        $this->field = $field;
        $this->isRelation = $this->isRelationSelect($field);;
    }

    public static function fromRequest(string $item)
    {
        return new self($item);
    }

    private function isRelationSelect($item)
    {
        if (!Str::contains($item, '.')) {
            return false;
        }
        [$relation, $field] = explode(".", $item);
        $this->field = $field;
        $this->relation = $relation;
        return true;
    }
}
