<?php

namespace GhoniJee\DxAdapter\Data;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SortData
{
    public $field;

    public $type;

    public $relationMethod;

    public bool $isRelation = false;

    public function __construct(array $data)
    {
        $this->field = $data['selector'];
        $this->isRelationField();
        $this->type = $data['desc'] ? 'DESC' : 'ASC';
    }

    public static function fromRequest($data)
    {
        $data = (array) $data;
        return new self($data);
    }

    public function isRelationField()
    {
        if (Str::contains($this->field, '.')) {
            $this->isRelation = true;
            [$this->relationMethod, $this->field] = collect(explode('.', $this->field))
                ->pipe(function (Collection $parts) {
                    return [
                        $parts->except(count($parts) - 1)->implode('.'),
                        $parts->last(),
                    ];
                });
        }
    }
}
