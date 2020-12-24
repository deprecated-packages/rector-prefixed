<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Exception;

use InvalidArgumentException;
use _PhpScoper0a6b37af0871\PhpParser\Lexer;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use function get_class;
use function sprintf;
class NoNodePosition extends \InvalidArgumentException
{
    public static function fromNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : self
    {
        return new self(\sprintf('%s doesn\'t contain position. Your %s is not configured properly', \get_class($node), \_PhpScoper0a6b37af0871\PhpParser\Lexer::class));
    }
}
