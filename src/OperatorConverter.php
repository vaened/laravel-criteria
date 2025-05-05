<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria;

use InvalidArgumentException;
use Vaened\CriteriaCore\Keyword\FilterOperator;

use function sprintf;

final class OperatorConverter
{
    public static function convert(FilterOperator $operator): string
    {
        return match ($operator) {
            FilterOperator::Equal    => '=',
            FilterOperator::NotEqual => '<>',
            FilterOperator::Gt       => '>',
            FilterOperator::Gte      => '>=',
            FilterOperator::Lt       => '<',
            FilterOperator::Lte      => '<=',
            FilterOperator::Contains,
            FilterOperator::StartsWith,
            FilterOperator::EndsWith => 'LIKE',

            default                  => throw new InvalidArgumentException(
                sprintf("The operator <%s> is not supported by eloquent", $operator->name)
            ),
        };
    }
}
