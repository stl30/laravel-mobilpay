<?php

namespace Stl30\LaravelMobilpay\Tests;

use Orchestra\Testbench\TestCase;
use Stl30\LaravelMobilpay\LaravelMobilpayServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelMobilpayServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
