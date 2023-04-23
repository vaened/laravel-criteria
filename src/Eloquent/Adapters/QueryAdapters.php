<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Eloquent\Adapters;


use Vaened\Support\Types\ArrayObject;

final class QueryAdapters extends ArrayObject
{
    protected function type(): string
    {
        return QueryAdapter::class;
    }
}
