<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Tests\Utils\Criterias;

use DateTimeInterface;
use Vaened\CriteriaCore\Keyword\FilterOperator;

final class PatientAffiliation extends Statement
{
    private function __construct(FilterOperator $operator, mixed $value)
    {
        parent::__construct('affiliated_at', $operator, $value);
    }

    public static function between(DateTimeInterface $start, DateTimeInterface $end): self
    {
        return new self(FilterOperator::Between, [$start->format('Y-m-d H:i:s.v'), $end->format('Y-m-d H:i:s.v')]);
    }
}
