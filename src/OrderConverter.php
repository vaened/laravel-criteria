<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria;

use InvalidArgumentException;
use Vaened\CriteriaCore\Keyword\OrderType;

use function sprintf;

final class OrderConverter
{
    public static function convert(OrderType $type): string
    {
        return match ($type) {
            OrderType::Asc  => 'asc',
            OrderType::Desc => 'desc',
            default         => throw new InvalidArgumentException(
                sprintf("The order type <%s> is not supported by eloquent", $type->name)
            ),
        };
    }
}
