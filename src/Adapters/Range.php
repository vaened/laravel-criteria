<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Adapters;

use Illuminate\Database\Eloquent\Builder;
use Vaened\CriteriaCore\Keyword\FilterOperator;

use function Lambdish\Phunctional\apply;

final class Range extends Adapter
{
    public function adapt(Builder $query): Builder
    {
        $values = (array)$this->filter->value()->primitive();

        return match ($this->filter->operator()) {
            FilterOperator::Between,
            FilterOperator::NotBetween,
            => apply($this->between($values), [$query]),

            FilterOperator::In,
            FilterOperator::NotIn,
            => apply($this->in($values), [$query])
        };
    }

    public function supportOperators(): array
    {
        return [
            FilterOperator::In,
            FilterOperator::NotIn,
            FilterOperator::Between,
            FilterOperator::NotBetween,
        ];
    }

    private function between(array $values): callable
    {
        return fn(Builder $query) => $query->whereBetween(...$this->params($values, FilterOperator::NotBetween));
    }

    private function in(array $values): callable
    {
        return fn(Builder $query) => $query->whereIn(...$this->params($values, FilterOperator::NotIn));
    }

    private function params(array $values, FilterOperator $operator): array
    {
        return [
            $this->filter->field(),
            $values,
            'and',
            $this->operatorIs($operator)
        ];
    }
}
