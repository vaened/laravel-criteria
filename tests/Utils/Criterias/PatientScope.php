<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Tests\Utils\Criterias;

use Vaened\CriteriaCore\Directives\Expression;
use Vaened\CriteriaCore\Directives\Scope;
use Vaened\CriteriaCore\Scoped;

final class PatientScope
{
    public static function account(Expression ...$expressions): Scope
    {
        return Scoped::of('account', $expressions);
    }

    public static function accounted(): Scope
    {
        return Scoped::of('account', []);
    }
}
