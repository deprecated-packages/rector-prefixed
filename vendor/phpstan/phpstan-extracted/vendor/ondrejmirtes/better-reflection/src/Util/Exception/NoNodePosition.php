<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Exception;

use InvalidArgumentException;
use _PhpScoperb75b35f52b74\PhpParser\Lexer;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use function get_class;
use function sprintf;
class NoNodePosition extends \InvalidArgumentException
{
    public static function fromNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : self
    {
        return new self(\sprintf('%s doesn\'t contain position. Your %s is not configured properly', \get_class($node), \_PhpScoperb75b35f52b74\PhpParser\Lexer::class));
    }
}
