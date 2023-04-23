<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria;

use BackedEnum;
use Illuminate\Database\Query\Expression;
use Vaened\CriteriaCore\Directives\Filter;
use Vaened\CriteriaCore\Directives\Scope;

use function Lambdish\Phunctional\apply;

abstract class indexer
{
    abstract public function indexes(): FilterBag;

    public function search(BackedEnum $index, string $queryString): null|Scope|Expression|Filter
    {
        $criteria = $this->indexes()->get($index);

        if (null === $criteria) {
            return null;
        }

        return apply($criteria, [$queryString]);
    }
}
