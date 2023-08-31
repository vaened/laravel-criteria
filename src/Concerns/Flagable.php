<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Concerns;

use Vaened\Criteria\Filtrator;
use Vaened\Criteria\FlagBag;
use Vaened\Criteria\SearchEngine;
use Vaened\CriteriaCore\Directives\Expression;
use Vaened\CriteriaCore\Directives\Filter;
use Vaened\CriteriaCore\Directives\Scope;

/**
 * Facilitates the search by flags.
 *
 * @mixin SearchEngine
 */
trait Flagable
{
    abstract protected function filtrator(): Filtrator;

    public function filter(FlagBag $flags): self
    {
        $this->filtrator()
             ->only($flags)
             ->each(
                 fn(Scope|Expression|Filter $criteria) => $this->apply($criteria)
             );

        return $this;
    }
}
