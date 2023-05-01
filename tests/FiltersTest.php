<?php
/**
 * Created by enea dhack - 15/06/2020 20:06.
 */

namespace Vaened\Criteria\Tests;

use Vaened\Criteria\FlagBag;
use Vaened\Criteria\Tests\Utils\Filter;
use Vaened\Criteria\Tests\Utils\Models\Patient;

class FiltersTest extends DataBaseTestCase
{
    public function test_filter_only_with_account_patients(): void
    {
        $flags   = FlagBag::from([Filter::WithAccount]);
        $results = $this->searcher()->filter($flags)->get();

        $this->assertCount(1, $results);
    }

    public function test_filter_only_observed_patients(): void
    {
        $flags   = FlagBag::from([Filter::Observed]);
        $results = $this->searcher()->filter($flags)->get();
        $this->assertCount(3, $results);
        $this->assertCount(0, $results->filter(fn(Patient $patient) => null === $patient->observation));
    }
}
