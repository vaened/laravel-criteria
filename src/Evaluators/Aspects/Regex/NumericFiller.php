<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Evaluators\Aspects\Regex;

use Vaened\Criteria\Evaluators\StringFiller;

final class NumericFiller extends Numeric
{
    public function __construct(private readonly int $maxLength, int $minLength = 1)
    {
        parent::__construct($maxLength, $minLength);
    }

    public function formatValue(string $value): string
    {
        return StringFiller::from('0', $this->maxLength)->fill($value);
    }
}
