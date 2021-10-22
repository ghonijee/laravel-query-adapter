<?php

namespace GhoniJee\DxAdapter\Actions;

trait SerializeData
{
    private function replaceSingleQuote(string $key)
    {
        $this->{$key} = str_replace("'", '"', $this->request->{$key});
    }

    private function serializeData(string $key)
    {
        if (is_string($this->{$key})) {
            $this->{$key} = json_decode($this->{$key});
        }
    }
}
