<?php

namespace GhoniJee\DxAdapter\Data;

use Illuminate\Support\Str;

class SortData
{
    public $field;

    public $type;

    public function __construct(array $data)
    {
        $this->field = $data['selector'];
        $this->type = $data['desc'] ? 'DESC' : 'ASC';
    }

    public static function fromRequest(array $data)
    {
        return new self($data);
    }
}
