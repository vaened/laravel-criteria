<?php
/**
 * Created by enea dhack - 07/06/2020 20:14.
 */

namespace Vaened\Criteria\Tests\Utils;

use Closure;
use Vaened\Criteria\FilterBag;
use Vaened\Criteria\Filtrator;
use Vaened\Criteria\Tests\Utils\Criterias\PatientObservation;
use Vaened\Criteria\Tests\Utils\Criterias\PatientScope;

class FilterProvider extends Filtrator
{
    public function flags(): FilterBag
    {
        return FilterBag::open()
            ->register(Filter::Observed, $this->onlyObserved())
            ->register(Filter::WithAccount, $this->onlyWithAccount());
    }

    private function onlyObserved(): Closure
    {
        return static fn() => PatientObservation::isNotNull();
    }

    private function onlyWithAccount(): Closure
    {
        return static fn() => PatientScope::accounted();
    }
}
