<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Evaluators\Aspects\Plain;

use Vaened\Criteria\Evaluators\Aspect;
use Vaened\CriteriaCore\Keyword\FilterOperator;

final class Identical implements Aspect
{
    public function operator(): FilterOperator
    {
        return FilterOperator::Equal;
    }

    public function evaluate(string $value): bool
    {
        return !empty($value);
    }

    public function formatValue(string $value): string

    {
        return $value;
    }
}
