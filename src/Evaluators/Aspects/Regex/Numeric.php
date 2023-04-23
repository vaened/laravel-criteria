<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Evaluators\Aspects\Regex;

use Vaened\Criteria\Evaluators\Aspects\Regex;

use Vaened\CriteriaCore\Keyword\FilterOperator;

use function sprintf;

class Numeric extends Regex
{
    public function __construct(private readonly int $maxLength = 99, private readonly int $minLength = 1)
    {
    }

    public function operator(): FilterOperator
    {
        return FilterOperator::Equal;
    }

    public function formatValue(string $value): string
    {
        return $value;
    }

    protected function pattern(): string
    {
        return sprintf('/^[0-9]{%s,%s}$/', $this->minLength, $this->maxLength);
    }
}
