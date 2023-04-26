<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Evaluators;

use Vaened\CriteriaCore\Directives\Expression;
use Vaened\CriteriaCore\Directives\Filter;
use Vaened\CriteriaCore\Directives\Scope;

interface Field
{
    public function match(string $value): bool;

    public function solve(string $value): Scope|Expression|Filter;
}