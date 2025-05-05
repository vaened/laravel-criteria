<?php
/**
 * Created by enea dhack - 07/06/2020 20:14.
 */

namespace Vaened\Criteria\Tests\Utils;

use Closure;
use Vaened\Criteria\Tests\Utils\Criterias\PatientObservation;
use Vaened\Criteria\Tests\Utils\Criterias\PatientScope;
use Vaened\SearchEngine\FilterBag;
use Vaened\SearchEngine\Flagger;

class FlagFiltrator extends Flagger
{
    public function flags(): FilterBag
    {
        return FilterBag::open()
                        ->register(PatientFlag::Observed, $this->onlyObserved())
                        ->register(PatientFlag::WithAccount, $this->onlyWithAccount());
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
