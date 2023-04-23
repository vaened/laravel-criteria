<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Evaluators;


final class Field
{
    public function __construct(private readonly string $field, private readonly Aspect $aspect)
    {
    }

    public static function is(string $field, Aspect $aspect): self
    {
        return new self($field, $aspect);
    }

    public function name(): string
    {
        return $this->field;
    }

    public function aspect(): Aspect
    {
        return $this->aspect;
    }
}