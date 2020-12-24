<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Exception;

use InvalidArgumentException;
use _PhpScopere8e811afab72\PhpParser\Lexer;
use _PhpScopere8e811afab72\PhpParser\Node;
use function get_class;
use function sprintf;
class NoNodePosition extends \InvalidArgumentException
{
    public static function fromNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : self
    {
        return new self(\sprintf('%s doesn\'t contain position. Your %s is not configured properly', \get_class($node), \_PhpScopere8e811afab72\PhpParser\Lexer::class));
    }
}
