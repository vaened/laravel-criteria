<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Adapters;

use Illuminate\Database\Eloquent\Builder;
use Vaened\CriteriaCore\Keyword\FilterOperator;

final class Contains extends Adapter
{
    public function adapt(Builder $query): Builder
    {
        return $query->where($this->filter->field(), $this->operator(), $this->decoratedValue());
    }

    public function supportOperators(): array
    {
        return [
            FilterOperator::Contains,
            FilterOperator::StartsWith,
            FilterOperator::EndsWith,
        ];
    }

    private function decoratedValue(): string
    {
        $queryString = (string)$this->filter->value()->primitive();

        return match ($this->filter->operator()) {
            FilterOperator::Contains   => "%$queryString%",
            FilterOperator::StartsWith => "$queryString%",
            FilterOperator::EndsWith   => "%$queryString"
        };
    }
}
