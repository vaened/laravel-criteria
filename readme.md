# Laravel Criteria

Search engine builder for eloquent

```bash
composer require vaened/laravel-criteria
```

## Usage

Turns a php class into a powerful, readable and friendly [`Query Builder`](./tests/Utils/Searcher.php).

```php
use Flagable, Indexed;

public function __construct(
    private readonly IndexRepository $index,
    private readonly FlagFiltrator   $filter
) {
    $this->apply(Criterias\PatientDeletionDate::without());
}


public function affiliatedBetween(DateTimeInterface $start, DateTimeInterface $end): self
{
    $this->apply(Criterias\PatientAffiliation::between($start, $end));
}

public function observationLikeTo(string $observation): self
{
    $this->apply(Criterias\PatientObservation::startsWith($observation));
}

public function onlyObserved(): self
{
    $this->apply(Criterias\PatientObservation::isNotNull());
}

public function withoutObservation(): self
{
    $this->apply(Criterias\PatientObservation::isNull());
}

public function historyEqualsTo(string $clinicHistory): self
{
    $this->apply(Criterias\PatientClinicHistory::equals($clinicHistory));
}

public function documentNotEqualsTo(string $documentNumber): self
{
    $this->apply(Criterias\PatientIdentityDocument::notEquals($documentNumber));
}

public function inDocuments(array $documentNumbers): self
{
    $this->apply(Criterias\PatientIdentityDocument::in($documentNumbers));
}

protected function query(): Builder
{
    return Patient::query();
}
```

### indexed

Query by [`Index`](./tests/Utils/IndexRepository.php), evaluate the search strings and determine the index based on the given pattern.

```php
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
        Query::must(
            target: 'document', mode: FilterOperator::Equal, expression: new NumericFixer(8)
        ),
    )->solve($queryString) ?: PatientName::startsWith($queryString);
}
```

### Filters

Facility to apply dynamic [`Filters`](./tests/Utils/FlagFiltrator.php) through php enumerations.

```php
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
```

## More documentation

You can find a lot of comments within the source code as well as the tests located in the `tests` directory.