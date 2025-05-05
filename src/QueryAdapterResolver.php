<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria;

use InvalidArgumentException;
use Vaened\Criteria\Adapters\Comparison;
use Vaened\Criteria\Adapters\Contains;
use Vaened\Criteria\Adapters\QueryAdapter;
use Vaened\Criteria\Adapters\Range;
use Vaened\CriteriaCore\Directives\Filter;
use Vaened\CriteriaCore\Keyword\FilterOperator;

use function sprintf;

final class QueryAdapterResolver
{
    public static function resolve(Filter $filter): QueryAdapter
    {
        return match ($filter->operator()) {
            FilterOperator::Equal,
            FilterOperator::NotEqual,
            FilterOperator::Gt,
            FilterOperator::Gte,
            FilterOperator::Lt,
            FilterOperator::Lte,
                    => new Comparison($filter),

            FilterOperator::In,
            FilterOperator::NotIn,
            FilterOperator::Between,
            FilterOperator::NotBetween,
                    => new Range($filter),

            FilterOperator::Contains,
            FilterOperator::StartsWith,
            FilterOperator::EndsWith,
                    => new Contains($filter),

            default => throw new InvalidArgumentException(
                sprintf("The operator <%s> does not have an adapter", $filter->operator()->name)
            ),
        };
    }
}
