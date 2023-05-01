<?php
/**
 * Created by enea dhack - 12/07/2020 20:57.
 */

namespace Vaened\Criteria\Tests;

use Carbon\Carbon;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function assertCarbonEquals($expected, Carbon $actual): void
    {
        $this->assertEquals(Carbon::createFromFormat('Y-m-d H:i:s', $expected)->toDateTimeString(), $actual->toDateTimeString());
    }
}
