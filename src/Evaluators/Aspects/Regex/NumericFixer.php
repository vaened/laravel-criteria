<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Evaluators\Aspects\Regex;

final class NumericFixer extends Numeric
{
    public function __construct(int $length)
    {
        parent::__construct($length, $length);
    }
}
