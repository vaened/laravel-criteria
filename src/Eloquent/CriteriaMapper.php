<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Eloquent;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Vaened\Criteria\Eloquent\Adapters\Compound;
use Vaened\Criteria\Eloquent\Adapters\QueryAdapter;
use Vaened\Criteria\Eloquent\Adapters\QueryAdapters;
use Vaened\CriteriaCore\Criteria;
use Vaened\CriteriaCore\Directives\{Expression, Filter, Scope};
use Vaened\CriteriaCore\Expressions;

use function array_merge;
use function Lambdish\Phunctional\each;

final class CriteriaMapper
{
    public function __construct(private readonly Criteria $criteria)
    {
    }

    public function apply(EloquentBuilder $query, ?QueryAdapters $hydrators = null): EloquentBuilder
    {
        $this->applyAllFilters($query);
        $this->applyQueryHydrators($query, $hydrators ?: QueryAdapters::empty());
        $this->applyLimits($query);
        $this->applyOrder($query);

        return $query;
    }

    public function applyQueryHydrators(EloquentBuilder $query, QueryAdapters $adapters): void
    {
        each($this->adapt($query), $adapters->items());
    }

    private function applyAllFilters(EloquentBuilder $query): void
    {
        each($this->adapt($query), $this->adapters());
    }

    private function applyLimits(EloquentBuilder $query): void
    {
        if ($this->criteria->limit() > 0) {
            $query->limit($this->criteria->limit());
        }
    }

    private function applyOrder(EloquentBuilder $query): void
    {
        if ($this->criteria->hasOrder()) {
            $query->orderBy(
                $this->criteria->order()->orderBy(),
                OrderConverter::convert($this->criteria->order()->orderType())
            );
        }
    }

    private function adapt(EloquentBuilder $query): callable
    {
        return static fn(QueryAdapter $adapter) => $adapter->adapt($query);
    }

    private function adapters(): array
    {
        return array_merge($this->localContexts(), $this->scopedContexts());
    }

    private function localContexts(): array
    {
        $local = $this->criteria->scopes()->filter(static fn(Scope $scope) => $scope->isLocal());

        return $local->map(fn(Scope $context) => Compound::create($this->adaptily($context->expressions())));
    }

    private function scopedContexts(): array
    {
        $scoped = $this->criteria->scopes()->filter(static fn(Scope $scope) => !$scope->isLocal());

        return $scoped->map(
            fn(Scope $scope) => Compound::related(
                $scope->name(),
                $this->adaptily($scope->expressions())
            )
        );
    }

    private function adaptily(Expressions $expressions): array
    {
        return $expressions->flatMap($this->convertToAdapter());
    }

    private function convertToAdapter(): callable
    {
        return static fn(Expression $expression): array => $expression->filters()->map(
            static fn(Filter $filter): QueryAdapter => QueryAdapterResolver::resolve($filter)
        );
    }
}
