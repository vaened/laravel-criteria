<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria;

use BackedEnum;
use Vaened\Support\Types\ArrayObject;

final class FlagBag extends ArrayObject
{
    protected function type(): string
    {
        return BackedEnum::class;
    }
}
