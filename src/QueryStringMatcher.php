<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria;

use Vaened\Criteria\Evaluators\Aspect;
use Vaened\Criteria\Evaluators\Field;
use Vaened\Criteria\Evaluators\ValueMultiplier;
use Vaened\CriteriaCore\Directives\Expression;
use Vaened\CriteriaCore\Filters;
use Vaened\CriteriaCore\Keyword\FilterOperator;
use Vaened\CriteriaCore\Statement;
use Vaened\CriteriaCore\Statements;

final class QueryStringMatcher
{
    private readonly array $fields;

    public function __construct(Field ...$fields)
    {
        $this->fields = $fields;
    }

    public static function of(Field ...$fields): self
    {
        return new self(...$fields);
    }

    public function solve(string $value): ?Expression
    {
        $field = $this->firstMatchOf($value);

        if (null === $field) {
            return null;
        }

        return new Statements(
            Filters::from([
                Statement::that(
                    $field->name(),
                    $this->operatorFor($field->aspect()),
                    $this->format($field->aspect(), $value)
                )
            ])
        );
    }

    private function firstMatchOf(string $value): ?Field
    {
        foreach ($this->fields as $field) {
            if ($this->match($field, $value)) {
                return $field;
            }
        }

        return null;
    }

    private function match(Field $field, string $value): bool
    {
        if (ValueMultiplier::canApplyFor($field->aspect(), $value)) {
            return ValueMultiplier::evaluate($field->aspect(), $value);
        }

        return $field->aspect()->evaluate($value);
    }

    private function format(Aspect $aspect, string $value): mixed
    {
        if (ValueMultiplier::canApplyFor($aspect, $value)) {
            return ValueMultiplier::format($aspect, $value);
        }

        return $aspect->formatValue($value);
    }

    private function operatorFor(Aspect $aspect): FilterOperator
    {
        if (ValueMultiplier::isSupportedOperator($aspect->operator())) {
            return ValueMultiplier::transformOperator($aspect);
        }

        return $aspect->operator();
    }
}
