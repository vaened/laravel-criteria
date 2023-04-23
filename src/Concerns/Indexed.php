<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Concerns;

use BackedEnum;
use Vaened\Criteria\indexer;
use Vaened\Criteria\SearchEngine;

/**
 * Facilitates the search by indexes.
 *
 * @mixin SearchEngine
 */
trait Indexed
{
    abstract protected function indexer(): indexer;

    public function search(BackedEnum $index, ?string $queryString): static
    {
        if (
            null !== $queryString &&
            null !== (
            $criteria = $this->indexer()->search($index, $queryString)
            )
        ) {
            $this->apply($criteria);
        }

        return $this;
    }
}
