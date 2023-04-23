<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria;

use function Lambdish\Phunctional\apply;
use function Lambdish\Phunctional\map;

abstract class Filtrator
{
    abstract public function flags(): FilterBag;

    protected function only(FlagBag $flags): array
    {
        return map(
            fn(callable $criteria) => apply($criteria),
            $this->flags()->only($flags)
        );
    }
}
