<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Evaluators\Aspects;

use Vaened\Criteria\Evaluators\Aspect;

use function preg_match;

abstract class Regex implements Aspect
{
    abstract protected function pattern(): string;

    public function evaluate(string $value): bool
    {
        return preg_match($this->pattern(), $value) > 0;
    }
}
