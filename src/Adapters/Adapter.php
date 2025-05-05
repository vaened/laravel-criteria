<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Adapters;

use InvalidArgumentException;
use Vaened\Criteria\OperatorConverter;
use Vaened\CriteriaCore\Directives\Filter;
use Vaened\CriteriaCore\Keyword\FilterOperator;

use function in_array;
use function sprintf;

abstract class Adapter implements QueryAdapter
{
    public function __construct(protected readonly Filter $filter)
    {
        $this->ensureOperatorsAreSupported($filter->operator());
    }

    abstract public function supportOperators(): array;

    protected function operator(): string
    {
        return OperatorConverter::convert($this->filter->operator());
    }

    protected function operatorIs(FilterOperator $operator): bool
    {
        return $this->filter->operator() === $operator;
    }

    private function ensureOperatorsAreSupported(FilterOperator $operator): void
    {
        if (!$this->isSupportedOperator($operator)) {
            throw new InvalidArgumentException(sprintf('The constraint <%s> cannot handle this operator', static::class));
        }
    }

    private function isSupportedOperator(FilterOperator $operator): bool
    {
        return in_array($operator, $this->supportOperators(), true);
    }
}