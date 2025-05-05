<?php
/**
 * Created by enea dhack - 07/06/2020 20:00.
 */

namespace Vaened\Criteria\Tests\Utils;

use Closure;
use Vaened\Criteria\Tests\Utils\Criterias\PatientIdentityDocument;
use Vaened\Criteria\Tests\Utils\Criterias\PatientName;
use Vaened\CriteriaCore\Keyword\FilterOperator;
use Vaened\SearchEngine\Definitions\Fields\Query;
use Vaened\SearchEngine\Definitions\Patterns\FixedNumber;
use Vaened\SearchEngine\FilterBag;
use Vaened\SearchEngine\Indexer;
use Vaened\SearchEngine\QueryStringMatcher;

class IndexRepository extends Indexer
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
            Query::must(target: 'document', operator: FilterOperator::Equal, pattern: new FixedNumber(8)),
        )->resolve($queryString) ?: PatientName::startsWith($queryString);
    }
}
