<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocParser\StaticDoctrineAnnotationParser;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode;
use PHPStan\PhpDocParser\Lexer\Lexer;
use Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode;
use Rector\BetterPhpDocParser\PhpDocParser\ClassAnnotationMatcher;
use Rector\BetterPhpDocParser\PhpDocParser\StaticDoctrineAnnotationParser;
use Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator;
use Rector\Core\Configuration\CurrentNodeProvider;
use Rector\Core\Exception\ShouldNotHappenException;
final class PlainValueParser
{
    /**
     * @var StaticDoctrineAnnotationParser
     */
    private $staticDoctrineAnnotationParser;
    /**
     * @var ClassAnnotationMatcher
     */
    private $classAnnotationMatcher;
    /**
     * @var CurrentNodeProvider
     */
    private $currentNodeProvider;
    public function __construct(\Rector\BetterPhpDocParser\PhpDocParser\ClassAnnotationMatcher $classAnnotationMatcher, \Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider)
    {
        $this->classAnnotationMatcher = $classAnnotationMatcher;
        $this->currentNodeProvider = $currentNodeProvider;
    }
    /**
     * @required
     */
    public function autowirePlainValueParser(\Rector\BetterPhpDocParser\PhpDocParser\StaticDoctrineAnnotationParser $staticDoctrineAnnotationParser) : void
    {
        $this->staticDoctrineAnnotationParser = $staticDoctrineAnnotationParser;
    }
    /**
     * @return bool|int|mixed|string
     */
    public function parseValue(\Rector\BetterPhpDocParser\ValueObject\Parser\BetterTokenIterator $tokenIterator)
    {
        $currentTokenValue = $tokenIterator->currentTokenValue();
        // temporary hackaround multi-line doctrine annotations
        if ($tokenIterator->isCurrentTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_END)) {
            return $currentTokenValue;
        }
        // consume the token
        $tokenIterator->next();
        // normalize value
        if ($currentTokenValue === 'false') {
            return new \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode();
        }
        if ($currentTokenValue === 'true') {
            return new \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode();
        }
        if (\is_numeric($currentTokenValue) && (string) (int) $currentTokenValue === $currentTokenValue) {
            return new \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode($currentTokenValue);
        }
        while ($tokenIterator->isCurrentTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_DOUBLE_COLON) || $tokenIterator->isCurrentTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_IDENTIFIER)) {
            $currentTokenValue .= $tokenIterator->currentTokenValue();
            $tokenIterator->next();
        }
        // nested entity!
        if ($tokenIterator->isCurrentTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_OPEN_PARENTHESES)) {
            // @todo
            $annotationShortName = $currentTokenValue;
            $values = $this->staticDoctrineAnnotationParser->resolveAnnotationMethodCall($tokenIterator);
            $currentNode = $this->currentNodeProvider->getNode();
            if (!$currentNode instanceof \PhpParser\Node) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            $fullyQualifiedAnnotationClass = $this->classAnnotationMatcher->resolveTagFullyQualifiedName($annotationShortName, $currentNode);
            // keep the last ")"
            $tokenIterator->tryConsumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_PHPDOC_EOL);
            $tokenIterator->consumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_CLOSE_PARENTHESES);
            return new \Rector\BetterPhpDocParser\PhpDoc\DoctrineAnnotationTagValueNode($fullyQualifiedAnnotationClass, $annotationShortName, $values);
        }
        return $currentTokenValue;
    }
}
