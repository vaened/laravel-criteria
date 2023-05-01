<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Tests\Utils\Criterias;

use Vaened\CriteriaCore\Directives\Filter;
use Vaened\CriteriaCore\Keyword\FilterField;
use Vaened\CriteriaCore\Keyword\FilterOperator;
use Vaened\CriteriaCore\Keyword\FilterValue;

abstract class Statement implements Filter
{
    private readonly FilterField $field;

    private readonly FilterValue $value;

    protected function __construct(
        string                          $column,
        private readonly FilterOperator $operator,
        mixed                           $value
    ) {
        $this->field = new FilterField($column);
        $this->value = new FilterValue($value);
    }

    public function field(): FilterField
    {
        return $this->field;
    }

    public function operator(): FilterOperator
    {
        return $this->operator;
    }

    public function value(): FilterValue
    {
        return $this->value;
    }
}
