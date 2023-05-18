<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Evaluators;

use Vaened\Criteria\OperatorCannotBeConvertedToMultiple;
use Vaened\CriteriaCore\Keyword\FilterOperator;
use Vaened\Support\Types\ArrayList;

use function array_key_exists;
use function explode;
use function str_contains;
use function trim;

final class ValueMultiplier
{
    private const SEPARATOR = ',';

    public static function canApplyFor(FilterOperator $operator, string $value): bool
    {
        return str_contains($value, self::SEPARATOR) && self::isSupportedOperator($operator);
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

    public static function transform(FilterOperator $operator): FilterOperator
    {
        return self::supportedOperators()[$operator->name]
            ?? throw new OperatorCannotBeConvertedToMultiple($operator);
    }

    public static function format(Aspect $aspect, string $value): array
    {
        return ArrayList::from(explode(self::SEPARATOR, $value))
            ->map(static fn(string $val) => trim($val))
            ->filter(static fn(string $val) => $aspect->evaluate($val))
            ->map(static fn(string $val) => $aspect->formatValue($val))
            ->values();
    }

    private static function supportedOperators(): array
    {
        return [
            FilterOperator::Equal->name    => FilterOperator::In,
            FilterOperator::NotEqual->name => FilterOperator::NotIn,
        ];
    }
}
