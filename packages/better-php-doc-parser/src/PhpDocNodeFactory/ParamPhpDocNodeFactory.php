<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\PhpDocNodeFactory;

use PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ParserException;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TokenIterator;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode;
use Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver;
use RectorPrefix20201227\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use RectorPrefix20201227\Symplify\PackageBuilder\Reflection\PrivatesCaller;
/**
 * Same as original + also allows "&" reference: https://github.com/rectorphp/rector/pull/1735
 */
final class ParamPhpDocNodeFactory
{
    /**
     * @var PrivatesAccessor
     */
    private $privatesAccessor;
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    /**
     * @var PhpDocParser
     */
    private $phpDocParser;
    /**
     * @var AttributeAwareNodeFactory
     */
    private $attributeAwareNodeFactory;
    /**
     * @var AnnotationContentResolver
     */
    private $annotationContentResolver;
    public function __construct(\Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver $annotationContentResolver, \Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory, \RectorPrefix20201227\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor, \RectorPrefix20201227\Symplify\PackageBuilder\Reflection\PrivatesCaller $privatesCaller)
    {
        $this->privatesAccessor = $privatesAccessor;
        $this->privatesCaller = $privatesCaller;
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
        $this->annotationContentResolver = $annotationContentResolver;
    }
    public function createFromTokens(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : ?\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        try {
            $tokenIterator->pushSavePoint();
            $attributeAwareParamTagValueNode = $this->parseParamTagValue($tokenIterator);
            $tokenIterator->dropSavePoint();
            return $attributeAwareParamTagValueNode;
        } catch (\PHPStan\PhpDocParser\Parser\ParserException $parserException) {
            $tokenIterator->rollback();
            $description = $this->privatesCaller->callPrivateMethod($this->phpDocParser, 'parseOptionalDescription', $tokenIterator);
            return new \PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode($description, $parserException);
        }
    }
    public function setPhpDocParser(\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser) : void
    {
        $this->phpDocParser = $phpDocParser;
    }
    /**
     * Override of parent private method to allow reference: https://github.com/rectorphp/rector/pull/1735
     */
    private function parseParamTagValue(\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode
    {
        $originalTokenIterator = clone $tokenIterator;
        $annotationContent = $this->annotationContentResolver->resolveFromTokenIterator($originalTokenIterator);
        $typeParser = $this->privatesAccessor->getPrivateProperty($this->phpDocParser, 'typeParser');
        $type = $typeParser->parse($tokenIterator);
        $isVariadic = $tokenIterator->tryConsumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_VARIADIC);
        // extra value over parent
        $isReference = $tokenIterator->tryConsumeTokenType(\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_REFERENCE);
        $parameterName = $this->privatesCaller->callPrivateMethod($this->phpDocParser, 'parseRequiredVariableName', $tokenIterator);
        $description = $this->privatesCaller->callPrivateMethod($this->phpDocParser, 'parseOptionalDescription', $tokenIterator);
        $type = $this->attributeAwareNodeFactory->createFromNode($type, $annotationContent);
        return new \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode($type, $isVariadic, $parameterName, $description, $isReference);
    }
}
