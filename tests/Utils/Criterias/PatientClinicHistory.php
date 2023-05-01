<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Tests\Utils\Criterias;

use Vaened\CriteriaCore\Keyword\FilterOperator;

final class PatientClinicHistory extends Statement
{
    private function __construct(FilterOperator $operator, mixed $value)
    {
        parent::__construct('history', $operator, $value);
    }

    public static function equals(string $clinicHistory): self
    {
        return new self(FilterOperator::Equal, $clinicHistory);
    }
}
