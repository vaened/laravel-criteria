<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Evaluators;


use Vaened\CriteriaCore\Keyword\FilterOperator;

interface Aspect
{
    public function operator(): FilterOperator;

    public function evaluate(string $value): bool;

    public function formatValue(string $value): mixed;
}