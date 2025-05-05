<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Vaened\Criteria\Adapters\Compound;
use Vaened\Criteria\Adapters\QueryAdapter;
use Vaened\Criteria\Adapters\QueryAdapters;
use Vaened\CriteriaCore\Criteria;
use Vaened\CriteriaCore\Directives\{Expression, Filter, Scope};
use Vaened\CriteriaCore\Expressions;
use Vaened\Support\Types\AbstractList;
use Vaened\Support\Types\ArrayList;

use function Lambdish\Phunctional\each;

final class CriteriaMapper
{
    public function __construct(private readonly Criteria $criteria)
    {
    }

    public function apply(EloquentBuilder $query, ?QueryAdapters $hydrators = null): EloquentBuilder
    {
        $this->applyAllFilters($query);
        $this->applyQueryHydrators($query, $hydrators ?: new QueryAdapters(AbstractList::Empty));
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

    private function adapters(): ArrayList
    {
        return $this->localContexts()->merge($this->scopedContexts());
    }

    private function localContexts(): ArrayList
    {
        $local = $this->criteria->scopes()->filter(static fn(Scope $scope) => $scope->isLocal());

        return $local->map(fn(Scope $context) => Compound::create($this->adaptily($context->expressions())->items()));
    }

    private function scopedContexts(): ArrayList
    {
        $scoped = $this->criteria->scopes()->filter(static fn(Scope $scope) => !$scope->isLocal());

        return $scoped->map(
            fn(Scope $scope) => Compound::related(
                $scope->name(),
                $this->adaptily($scope->expressions())->items()
            )
        );
    }

    private function adaptily(Expressions $expressions): ArrayList
    {
        return $expressions->flatMap($this->convertToAdapter());
    }

    private function convertToAdapter(): callable
    {
        return static fn(Expression $expression): ArrayList => $expression->filters()->map(
            static fn(Filter $filter): QueryAdapter => QueryAdapterResolver::resolve($filter)
        );
    }
}
