<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocInfo;

use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator;
use RectorPrefix20210408\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
final class TokenIteratorFactory
{
    /**
     * @var string
     */
    private const INDEX = 'index';
    /**
     * @var Lexer
     */
    private $lexer;
    /**
     * @var PrivatesAccessor
     */
    private $privatesAccessor;
    public function __construct(\PHPStan\PhpDocParser\Lexer\Lexer $lexer, \RectorPrefix20210408\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor)
    {
        $this->lexer = $lexer;
        $this->privatesAccessor = $privatesAccessor;
    }
    public function create(string $content) : \Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator
    {
        $tokens = $this->lexer->tokenize($content);
        return new \Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator($tokens);
    }
    public function createFromTokenIterator(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator
    {
        if ($tokenIterator instanceof \Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator) {
            return $tokenIterator;
        }
        $tokens = $this->privatesAccessor->getPrivateProperty($tokenIterator, 'tokens');
        $betterTokenIterator = new \Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator($tokens);
        // keep original position
        $currentIndex = $this->privatesAccessor->getPrivateProperty($tokenIterator, 'index');
        $this->privatesAccessor->setPrivateProperty($betterTokenIterator, self::INDEX, $currentIndex);
        return $betterTokenIterator;
    }
}
