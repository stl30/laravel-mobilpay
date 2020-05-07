<?php

namespace Stl30\LaravelMobilpay;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Stl30\LaravelMobilpay\Skeleton\SkeletonClass
 */
class LaravelMobilpayFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-mobilpay';
    }
}
