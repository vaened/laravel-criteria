<?php
/**
 * Created by enea dhack - 07/06/2020 20:00.
 */

namespace Vaened\Criteria\Tests\Utils;

use Closure;
use Vaened\Criteria\Evaluators\Aspects\Regex\NumericFixer;
use Vaened\Criteria\Evaluators\Fields\Query;
use Vaened\Criteria\FilterBag;
use Vaened\Criteria\indexer;
use Vaened\Criteria\QueryStringMatcher;
use Vaened\Criteria\Tests\Utils\Criterias\PatientIdentityDocument;
use Vaened\Criteria\Tests\Utils\Criterias\PatientName;

class IndexRepository extends indexer
{
    public function indexes(): FilterBag
    {
        return FilterBag::open()
            ->register(PatientIndex::Patient, $this->patientMustBe())
            ->register(PatientIndex::Name, $this->nameStartsWith())
            ->register(PatientIndex::Document, $this->documentIsEqualsTo());
    }

    protected function documentIsEqualsTo(): Closure
    {
        return static fn(string $documentNumber) => PatientIdentityDocument::equals($documentNumber);
    }

    protected function nameStartsWith(): Closure
    {
        return static fn(string $name) => PatientName::startsWith($name);
    }

    private function patientMustBe(): callable
    {
        return static fn(string $queryString) => QueryStringMatcher::of(
            Query::shouldEqualTo(new NumericFixer(8), 'document'),
        )->solve($queryString) ?: PatientName::startsWith($queryString);
    }
}
