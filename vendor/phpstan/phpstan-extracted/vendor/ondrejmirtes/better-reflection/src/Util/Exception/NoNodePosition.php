<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Exception;

use InvalidArgumentException;
use _PhpScoper0a2ac50786fa\PhpParser\Lexer;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use function get_class;
use function sprintf;
class NoNodePosition extends \InvalidArgumentException
{
    public static function fromNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : self
    {
        return new self(\sprintf('%s doesn\'t contain position. Your %s is not configured properly', \get_class($node), \_PhpScoper0a2ac50786fa\PhpParser\Lexer::class));
    }
}
