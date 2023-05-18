<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Evaluators;

interface Aspect
{
    public function evaluate(string $value): bool;

    public function formatValue(string $value): mixed;
}