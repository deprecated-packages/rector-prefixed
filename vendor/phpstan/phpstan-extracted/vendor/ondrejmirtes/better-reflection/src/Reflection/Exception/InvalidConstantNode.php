<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\PrettyPrinter\Standard;
use RuntimeException;
use function sprintf;
use function substr;
class InvalidConstantNode extends \RuntimeException
{
    public static function create(\_PhpScopere8e811afab72\PhpParser\Node $node) : self
    {
        return new self(\sprintf('Invalid constant node (first 50 characters: %s)', \substr((new \_PhpScopere8e811afab72\PhpParser\PrettyPrinter\Standard())->prettyPrint([$node]), 0, 50)));
    }
}
