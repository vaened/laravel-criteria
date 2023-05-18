<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Evaluators\Fields;

use Vaened\Criteria\Evaluators\Aspect;
use Vaened\Criteria\Evaluators\Field;
use Vaened\Criteria\Evaluators\ValueMultiplier;
use Vaened\CriteriaCore\Directives\Filter;
use Vaened\CriteriaCore\Keyword\FilterOperator;
use Vaened\CriteriaCore\Statement;

final class Query implements Field
{
    public function __construct(
        private readonly string         $target,
        private readonly FilterOperator $operator,
        private readonly Aspect         $aspect,
    ) {
    }

    public static function must(string $target, FilterOperator $mode, Aspect $expression): self
    {
        return new self($target, $mode, $expression);
    }

    public function match(string $value): bool
    {
        if (ValueMultiplier::canApplyFor($this->operator, $value)) {
            return ValueMultiplier::evaluate($this->aspect, $value);
        }

        return $this->aspect->evaluate($value);
    }

    public function solve(string $value): Filter
    {
        return Statement::that(
            $this->target,
            $this->operator(),
            $this->format($value)
        );
    }

    private function operator(): FilterOperator
    {
        if (ValueMultiplier::isSupportedOperator($this->operator)) {
            return ValueMultiplier::transform($this->operator);
        }

        return $this->operator;
    }

    private function format(string $value): mixed
    {
        if (ValueMultiplier::canApplyFor($this->operator, $value)) {
            return ValueMultiplier::format($this->aspect, $value);
        }

        return $this->aspect->formatValue($value);
    }
}
