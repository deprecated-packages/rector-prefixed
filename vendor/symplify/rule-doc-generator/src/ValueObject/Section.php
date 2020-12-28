<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject;

final class Section
{
    /**
     * @var string
     * @noRector \Rector\DeadCode\Rector\ClassConst\RemoveUnusedClassConstantRector
     */
    public const REQUIRE = 'require';
    /**
     * @var string
     * @noRector \Rector\DeadCode\Rector\ClassConst\RemoveUnusedClassConstantRector
     */
    public const REQUIRE_DEV = 'require-dev';
}
