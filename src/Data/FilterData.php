<?php

namespace GhoniJee\DxAdapter\Data;

use DateTime;
use GhoniJee\DxAdapter\Enums\ValueDataType;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FilterData
{
    public $field;

    public $condition;

    public $value;

    public $type;

    public $relationMethod;

    public bool $isRelation = false;

    public function __construct($data)
    {
        list($this->field, $this->condition, $this->value) = $data;
        $this->isRelationFilter();
        $this->setValueType();
    }

    public static function fromRequest($data)
    {
        return new self($data);
    }

    public function setValueType()
    {
        switch (true) {
            case $this->isDateFormat():
                $this->type = ValueDataType::ISDATE;
                break;
            case $this->isBoolean():
                $this->type = ValueDataType::ISBOOLEAN;
                break;
            case $this->isNumeric():
                $this->type = ValueDataType::ISNUMERIC;
                break;
            case $this->isNull():
                $this->type = ValueDataType::ISNULL;
                break;
            case $this->isString():
                $this->type = ValueDataType::ISSTRING;
                break;
        }
    }

    private function isNull()
    {
        return is_null($this->value);
    }

    private function isString()
    {
        return is_string($this->value);
    }

    private function isBoolean()
    {
        return is_bool($this->value);
    }

    private function isDateFormat()
    {
        $makeDate = DateTime::createFromFormat("Y-m-d", $this->value);
        $isDateFormat = ($makeDate && $makeDate->format("Y-m-d") === $this->value);
        if ($isDateFormat) {
            return true;
        }
        return false;
    }

    private function isNumeric()
    {
        if ((is_numeric($this->value) && $this->condition != "contains")) {
            return true;
        }
        return false;
    }

    public function isRelationFilter()
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
