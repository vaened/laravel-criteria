<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Evaluators\Aspects\Regex;

use Vaened\Criteria\Evaluators\Aspects\Regex;
use Vaened\CriteriaCore\Keyword\FilterOperator;

final class Aphanumeric extends Regex
{
    public function operator(): FilterOperator
    {
    }

    public function formatValue(string $value): string
    {
        return $value;
    }

    protected function pattern(): string
    {
        return '^[\w\,\ ]+$';
    }
}