<?php

namespace Floo\DxAdapter;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Floo\DxAdapter\Skeleton\SkeletonClass
 */
class DxAdapterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'dx-adapter';
    }
}
