<?php

namespace Floo\DxAdapter\Data;

use DateTime;
use Floo\DxAdapter\Enums\ValueDataType;

class FilterData
{
    public $field;

    public $condition;

    public $value;

    public $type;

    public $relation;

    public function __construct($data)
    {
        list($this->field, $this->condition, $this->value) = $data;
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
            case $this->isString():
                $this->type = ValueDataType::ISSTRING;
                break;
        }
    }

    private function isString()
    {
        if (is_string($this->value)) {
            return true;
        }
        return false;
    }

    private function isBoolean()
    {
        if (is_bool($this->value)) {
            return true;
        }
        return false;
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
}
