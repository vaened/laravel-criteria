<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Adapters;

use Illuminate\Database\Eloquent\Builder;
use Vaened\CriteriaCore\Keyword\FilterOperator;

final class Comparison extends Adapter
{
    public function adapt(Builder $query): Builder
    {
        $value = $this->filter->value();

        if (!$value->isNull()) {
            return $query->where($this->filter->field(), $this->operator(), $value->primitive());
        }

        return $query->whereNull($this->filter->field(), 'and', $this->operatorIs(FilterOperator::NotEqual));
    }

    public function supportOperators(): array
    {
        return [
            FilterOperator::Equal,
            FilterOperator::NotEqual,
            FilterOperator::Gt,
            FilterOperator::Gte,
            FilterOperator::Lt,
            FilterOperator::Lte,
        ];
    }
}
