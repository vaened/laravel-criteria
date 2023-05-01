<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Tests\Utils\Criterias;

use Vaened\CriteriaCore\Keyword\FilterOperator;

final class PatientIdentityDocument extends Statement
{
    private function __construct(FilterOperator $operator, mixed $value)
    {
        parent::__construct('document', $operator, $value);
    }

    public static function equals(string $documentNumber): self
    {
        return new self(FilterOperator::Equal, $documentNumber);
    }

    public static function notEquals(string $documentNumber): self
    {
        return new self(FilterOperator::NotEqual, $documentNumber);
    }

    public static function in(array $documentNumbers): self
    {
        return new self(FilterOperator::In, $documentNumbers);
    }
}
