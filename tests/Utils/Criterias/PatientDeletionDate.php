<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Tests\Utils\Criterias;

use Vaened\CriteriaCore\Keyword\FilterOperator;

final class PatientDeletionDate extends Statement
{
    private function __construct(FilterOperator $operator)
    {
        parent::__construct('deleted_at', $operator, null);
    }

    public static function registered(): self
    {
        return new self(FilterOperator::NotEqual);
    }

    public static function without(): self
    {
        return new self(FilterOperator::Equal);
    }
}
