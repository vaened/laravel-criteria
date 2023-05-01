<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Tests\Utils\Criterias;

use Vaened\CriteriaCore\Keyword\FilterOperator;

final class PatientName extends Statement
{
    private function __construct(FilterOperator $operator, mixed $value)
    {
        parent::__construct('name', $operator, $value);
    }

    public static function startsWith(string $name): self
    {
        return new self(FilterOperator::StartsWith, $name);
    }
}