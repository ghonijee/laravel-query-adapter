<?php

namespace GhoniJee\DxAdapter;

use Illuminate\Support\Facades\Facade;

/**
 * @see \GhoniJee\DxAdapter\Skeleton\SkeletonClass
 */
class QueryAdapter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'query-adapter';
    }
}
