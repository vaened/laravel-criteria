<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Evaluators;

use Vaened\Criteria\OperatorCannotBeConvertedToMultiple;
use Vaened\CriteriaCore\Keyword\FilterOperator;

use function array_key_exists;
use function explode;
use function Lambdish\Phunctional\map;
use function str_contains;
use function trim;

final class ValueMultiplier
{
    private const SEPARATOR = ',';

    public static function canApplyFor(Aspect $aspect, string $value): bool
    {
        return str_contains($value, self::SEPARATOR) && self::isSupportedOperator($aspect->operator());
    }

    public static function evaluate(Aspect $aspect, string $value): bool
    {
        $values = explode(self::SEPARATOR, $value);

        foreach ($values as $val) {
            if ($aspect->evaluate(trim($val))) {
                return true;
            }
        }

        return false;
    }

    public static function isSupportedOperator(FilterOperator $operator): bool
    {
        return array_key_exists($operator->name, self::supportedOperators());
    }

    public static function transformOperator(Aspect $aspect): FilterOperator
    {
        return self::supportedOperators()[$aspect->operator()->name]
            ?? throw new OperatorCannotBeConvertedToMultiple($aspect->operator());
    }

    public static function format(Aspect $aspect, string $value): array
    {
        return map(
            fn(string $val) => $aspect->formatValue(trim($val)),
            explode(self::SEPARATOR, $value)
        );
    }

    private static function supportedOperators(): array
    {
        return [
            FilterOperator::Equal->name    => FilterOperator::In,
            FilterOperator::NotEqual->name => FilterOperator::NotIn,
        ];
    }
}
