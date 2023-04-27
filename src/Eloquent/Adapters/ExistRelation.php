<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Eloquent\Adapters;

use Illuminate\Database\Eloquent\Builder;

final class ExistRelation implements QueryAdapter
{
    public function __construct(private readonly string $relation)
    {
    }

    public function adapt(Builder $query): Builder
    {
        return $query->whereHas($this->relation);
    }
}
