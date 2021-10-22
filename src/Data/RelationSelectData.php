<?php

namespace GhoniJee\DxAdapter\Data;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class RelationSelectData
{
    public $field;

    public $relation;

    public function __construct(string $relation, Collection $field)
    {
        $this->field = $field;
        $this->relation = $relation;
    }

    public static function build(string $relation, Collection $field)
    {
        return new self($relation, $field);
    }
}
