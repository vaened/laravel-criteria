<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Tests\Utils\Criterias;

use Vaened\CriteriaCore\Keyword\FilterOperator;

final class PatientObservation extends Statement
{
    private function __construct(FilterOperator $operator, mixed $value)
    {
        parent::__construct('observation', $operator, $value);
    }

    public static function isNotNull(): self
    {
        return new self(FilterOperator::NotEqual, null);
    }

    public static function isNull(): self
    {
        return new self(FilterOperator::Equal, null);
    }

    public static function startsWith(string $observation): self
    {
        return new self(FilterOperator::StartsWith, $observation);
    }
}
