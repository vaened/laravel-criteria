<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Adapters;

use Vaened\Support\Types\SecureList;

final class QueryAdapters extends SecureList
{
    public static function from(iterable $adapters): self
    {
        return new self($adapters);
    }

    public static function type(): string
    {
        return QueryAdapter::class;
    }
}
