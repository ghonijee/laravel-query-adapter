<?php

namespace Floo\DxAdapter;

use Illuminate\Http\Request;

class DxAdapterRequest extends Request
{
    public static function fromRequest(Request $request): self
    {
        return static::createFrom($request, new self());
    }
}
