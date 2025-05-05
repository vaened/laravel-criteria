<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Vaened\Criteria\Eloquent\Adapters\ExistRelation;
use Vaened\Criteria\Eloquent\Adapters\QueryAdapter;
use Vaened\Criteria\Eloquent\Adapters\QueryAdapters;
use Vaened\Criteria\Eloquent\CriteriaMapper;
use Vaened\SearchEngine\AbstractSearchEngine;

use function array_merge;

/**
 * @template TModel
 */
abstract class SearchEngine extends AbstractSearchEngine
{
    protected array $preload   = [];

    protected array $unload    = [];

    protected int   $limit     = 0;

    private array   $hydrators = [];

    abstract protected function query(): EloquentBuilder;

    public function preload(string ...$relations): static
    {
        $this->preload = array_merge($this->preload, $relations);
        return $this;
    }

    public function unload(string ...$relations): static
    {
        $this->unload = array_merge($this->unload, $relations);
        return $this;
    }

    public function limit(int $limit): static
    {
        return $this->perPage($limit);
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->compoundQuery()->paginate($perPage);
    }

    /**
     * @return EloquentCollection<int, TModel>
     */
    public function get(): EloquentCollection
    {
        return $this->compoundQuery()->get();
    }

    /**
     * @return TModel
     */
    public function first(): mixed
    {
        return $this->compoundQuery()->first();
    }

    protected function exist(string $relation): void
    {
        $this->adapt(new ExistRelation($relation));
    }

    protected function adapt(QueryAdapter $hydrator): void
    {
        $this->hydrators[] = $hydrator;
    }

    protected function compoundQuery(): EloquentBuilder
    {
        return $this->mapper()->apply(
            query    : $this->query()->with($this->preload)->without($this->unload),
            hydrators: QueryAdapters::from($this->hydrators)
        );
    }

    private function mapper(): CriteriaMapper
    {
        return new CriteriaMapper($this->criteria());
    }
}
