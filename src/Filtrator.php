<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria;

use Vaened\Support\Types\ArrayList;

use function Lambdish\Phunctional\apply;

abstract class Filtrator
{
    abstract public function flags(): FilterBag;

    public function only(FlagBag $flags): ArrayList
    {
        return $this->flags()
                    ->only($flags)
                    ->map(static fn(callable $criteria) => apply($criteria));
    }
}
