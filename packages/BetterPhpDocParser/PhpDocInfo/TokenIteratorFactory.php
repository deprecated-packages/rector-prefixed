<?php

declare(strict_types=1);

namespace Rector\BetterPhpDocParser\PhpDocInfo;

use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator;
use Symplify\PackageBuilder\Reflection\PrivatesAccessor;

final class TokenIteratorFactory
{
    /**
     * @var string
     */
    const INDEX = 'index';

    /**
     * @var Lexer
     */
    private $lexer;

    /**
     * @var PrivatesAccessor
     */
    private $privatesAccessor;

    public function __construct(Lexer $lexer, PrivatesAccessor $privatesAccessor)
    {
        $this->lexer = $lexer;
        $this->privatesAccessor = $privatesAccessor;
    }

    public function create(string $content): BetterTokenIterator
    {
        $tokens = $this->lexer->tokenize($content);
        return new BetterTokenIterator($tokens);
    }

    public function createFromTokenIterator(TokenIterator $tokenIterator): BetterTokenIterator
    {
        if ($tokenIterator instanceof BetterTokenIterator) {
            return $tokenIterator;
        }

        $tokens = $this->privatesAccessor->getPrivateProperty($tokenIterator, 'tokens');
        $betterTokenIterator = new BetterTokenIterator($tokens);

        // keep original position
        $currentIndex = $this->privatesAccessor->getPrivateProperty($tokenIterator, 'index');
        $this->privatesAccessor->setPrivateProperty($betterTokenIterator, self::INDEX, $currentIndex);

        return $betterTokenIterator;
    }
}
