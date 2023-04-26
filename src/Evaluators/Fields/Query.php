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
    public function __construct(private readonly string $name, private readonly Aspect $aspect)
    {
    }

    public function match(string $value): bool
    {
        if (ValueMultiplier::canApplyFor($this->aspect, $value)) {
            return ValueMultiplier::evaluate($this->aspect, $value);
        }

        return $this->aspect->evaluate($value);
    }

    public function solve(string $value): Filter
    {
        return Statement::that(
            $this->name,
            $this->operator(),
            $this->format($value)
        );
    }

    private function operator(): FilterOperator
    {
        if (ValueMultiplier::isSupportedOperator($this->aspect->operator())) {
            return ValueMultiplier::transformOperator($this->aspect);
        }

        return $this->aspect->operator();
    }

    private function format(string $value): mixed
    {
        if (ValueMultiplier::canApplyFor($this->aspect, $value)) {
            return ValueMultiplier::format($this->aspect, $value);
        }

        return $this->aspect->formatValue($value);
    }
}
