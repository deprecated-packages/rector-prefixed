<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\ParserException;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesCaller;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocParser\AnnotationContentResolver $annotationContentResolver, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Ast\AttributeAwareNodeFactory $attributeAwareNodeFactory, \_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor, \_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesCaller $privatesCaller)
    {
        $this->privatesAccessor = $privatesAccessor;
        $this->privatesCaller = $privatesCaller;
        $this->attributeAwareNodeFactory = $attributeAwareNodeFactory;
        $this->annotationContentResolver = $annotationContentResolver;
    }
    public function createFromTokens(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : ?\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        try {
            $tokenIterator->pushSavePoint();
            $attributeAwareParamTagValueNode = $this->parseParamTagValue($tokenIterator);
            $tokenIterator->dropSavePoint();
            return $attributeAwareParamTagValueNode;
        } catch (\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\ParserException $parserException) {
            $tokenIterator->rollback();
            $description = $this->privatesCaller->callPrivateMethod($this->phpDocParser, 'parseOptionalDescription', $tokenIterator);
            return new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode($description, $parserException);
        }
    }
    public function setPhpDocParser(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser) : void
    {
        $this->phpDocParser = $phpDocParser;
    }
    /**
     * Override of parent private method to allow reference: https://github.com/rectorphp/rector/pull/1735
     */
    private function parseParamTagValue(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode
    {
        $originalTokenIterator = clone $tokenIterator;
        $annotationContent = $this->annotationContentResolver->resolveFromTokenIterator($originalTokenIterator);
        $typeParser = $this->privatesAccessor->getPrivateProperty($this->phpDocParser, 'typeParser');
        $type = $typeParser->parse($tokenIterator);
        $isVariadic = $tokenIterator->tryConsumeTokenType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_VARIADIC);
        // extra value over parent
        $isReference = $tokenIterator->tryConsumeTokenType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::TOKEN_REFERENCE);
        $parameterName = $this->privatesCaller->callPrivateMethod($this->phpDocParser, 'parseRequiredVariableName', $tokenIterator);
        $description = $this->privatesCaller->callPrivateMethod($this->phpDocParser, 'parseOptionalDescription', $tokenIterator);
        $type = $this->attributeAwareNodeFactory->createFromNode($type, $annotationContent);
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareParamTagValueNode($type, $isVariadic, $parameterName, $description, $isReference);
    }
}
