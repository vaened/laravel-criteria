<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Eloquent\Adapters;

use Illuminate\Database\Eloquent\Builder;

use function Lambdish\Phunctional\map;

final class Compound implements QueryAdapter
{
    public function __construct(
        private readonly array   $adapters,
        private readonly ?string $relationName = null,
    )
    {
    }

    public static function create(array $adapters): Compound
    {
        return new Compound($adapters);
    }

    public static function related(string $relationName, array $adapters): Compound
    {
        return new Compound($adapters, $relationName);
    }

    public function adapt(Builder $query): Builder
    {
        if (!$this->isRelated()) {
            return $query->where($this->applyAll($this->adapters));
        }

        return $query->whereHas($this->relationName, $this->applyAll($this->adapters));
    }

    private function isRelated(): bool
    {
        return $this->relationName !== null;
    }

    private function applyAll(array $adapters): callable
    {
        return static fn(Builder $query) => map(static fn(QueryAdapter $adapter) => $adapter->adapt($query), $adapters);
    }
}
