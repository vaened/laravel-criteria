<?php
/**
 * Created by enea dhack - 07/06/2020 19:50.
 */

namespace Vaened\Criteria\Tests\Utils;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Vaened\Criteria\SearchEngine;
use Vaened\Criteria\Tests\Utils\Models\Patient;
use Vaened\SearchEngine\Concerns\Flaggable;
use Vaened\SearchEngine\Concerns\Indexable;
use Vaened\SearchEngine\Flagger;
use Vaened\SearchEngine\Indexer;

class Searcher extends SearchEngine
{
    use Flaggable, Indexable;

    public function __construct(
        private readonly IndexRepository $index,
        private readonly FlagFiltrator   $filter
    )
    {
        $this->apply(Criterias\PatientDeletionDate::without());
    }

    public function affiliatedBetween(DateTimeInterface $start, DateTimeInterface $end): self
    {
        $this->apply(
            Criterias\PatientAffiliation::between($start, $end)
        );
        return $this;
    }

    public function observationLikeTo(string $observation): self
    {
        $this->apply(
            Criterias\PatientObservation::startsWith($observation)
        );
        return $this;
    }

    public function onlyWithAccount(): self
    {
        $this->exist('account');
        return $this;
    }

    public function onlyObserved(): self
    {
        $this->apply(
            Criterias\PatientObservation::isNotNull()
        );
        return $this;
    }

    public function withoutObservation(): self
    {
        $this->apply(
            Criterias\PatientObservation::isNull()
        );
        return $this;
    }

    public function historyEqualsTo(string $clinicHistory): self
    {
        $this->apply(
            Criterias\PatientClinicHistory::equals($clinicHistory)
        );

        return $this;
    }

    public function documentNotEqualsTo(string $documentNumber): self
    {
        $this->apply(
            Criterias\PatientIdentityDocument::notEquals($documentNumber)
        );

        return $this;
    }

    public function inDocuments(array $documentNumbers): self
    {
        $this->apply(
            Criterias\PatientIdentityDocument::in($documentNumbers)
        );

        return $this;
    }

    public function loadAccounts(): self
    {
        return $this->preload('account');
    }

    protected function query(): Builder
    {
        return Patient::query();
    }

    protected function indexer(): Indexer
    {
        return $this->index;
    }

    protected function flagger(): Flagger
    {
        return $this->filter;
    }
}
