<?php
/**
 * Created by enea dhack - 07/06/2020 20:00.
 */

namespace Vaened\Criteria\Tests\Utils;

use Closure;
use Vaened\Criteria\FilterBag;
use Vaened\Criteria\indexer;
use Vaened\Criteria\Tests\Utils\Criterias\PatientIdentityDocument;
use Vaened\Criteria\Tests\Utils\Criterias\PatientName;

class IndexProvider extends indexer
{
    public function indexes(): FilterBag
    {
        return FilterBag::open()
            ->register(Indexes::Name, $this->nameStartsWith())
            ->register(Indexes::Document, $this->documentIsEqualsTo());
    }

    protected function documentIsEqualsTo(): Closure
    {
        return static fn(string $documentNumber) => PatientIdentityDocument::equals($documentNumber);
    }

    protected function nameStartsWith(): Closure
    {
        return static fn(string $name) => PatientName::startsWith($name);
    }
}