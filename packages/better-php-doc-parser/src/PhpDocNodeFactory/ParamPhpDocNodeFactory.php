<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocNodeFactory;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\ParserException;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesCaller;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver $annotationContentResolver, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory, \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor, \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Reflection\PrivatesCaller $privatesCaller)
    {
        $this->privatesAccessor = $privatesAccessor;
        $this->privatesCaller = $privatesCaller;
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
        $this->annotationContentResolver = $annotationContentResolver;
    }
    public function createFromTokens(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : ?\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        try {
            $tokenIterator->pushSavePoint();
            $attributeAwareParamTagValueNode = $this->parseParamTagValue($tokenIterator);
            $tokenIterator->dropSavePoint();
            return $attributeAwareParamTagValueNode;
        } catch (\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\ParserException $parserException) {
            $tokenIterator->rollback();
            $description = $this->privatesCaller->callPrivateMethod($this->phpDocParser, 'parseOptionalDescription', $tokenIterator);
            return new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode($description, $parserException);
        }
    }
    public function setPhpDocParser(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser) : void
    {
        $this->phpDocParser = $phpDocParser;
    }
    /**
     * Override of parent private method to allow reference: https://github.com/rectorphp/rector/pull/1735
     */
    private function parseParamTagValue(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode
    {
        $originalTokenIterator = clone $tokenIterator;
        $annotationContent = $this->annotationContentResolver->resolveFromTokenIterator($originalTokenIterator);
        $typeParser = $this->privatesAccessor->getPrivateProperty($this->phpDocParser, 'typeParser');
        $type = $typeParser->parse($tokenIterator);
        $isVariadic = $tokenIterator->tryConsumeTokenType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_VARIADIC);
        // extra value over parent
        $isReference = $tokenIterator->tryConsumeTokenType(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_REFERENCE);
        $parameterName = $this->privatesCaller->callPrivateMethod($this->phpDocParser, 'parseRequiredVariableName', $tokenIterator);
        $description = $this->privatesCaller->callPrivateMethod($this->phpDocParser, 'parseOptionalDescription', $tokenIterator);
        $type = $this->attributeAwareNodeFactory->createFromNode($type, $annotationContent);
        return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode($type, $isVariadic, $parameterName, $description, $isReference);
    }
}
