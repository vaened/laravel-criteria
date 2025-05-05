<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Adapters;

use Illuminate\Database\Eloquent\Builder;

interface QueryAdapter
{
    public function adapt(Builder $query): Builder;
}
