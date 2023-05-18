<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Evaluators\Aspects\Regex;

use Vaened\Criteria\Evaluators\Aspects\Regex;

final class PartialText extends Regex
{
    public function formatValue(string $value): string
    {
        return $value;
    }

    protected function pattern(): string
    {
        return '/^(?!\s*$).+/';
    }
}
