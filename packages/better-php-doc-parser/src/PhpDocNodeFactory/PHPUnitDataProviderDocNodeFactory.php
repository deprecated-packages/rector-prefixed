<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocNodeFactory;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\InvalidTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\ParserException;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\DataProviderTagValueNode;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesCaller;
final class PHPUnitDataProviderDocNodeFactory
{
    /**
     * @var PrivatesCaller
     */
    private $privatesCaller;
    /**
     * @var PhpDocParser
     */
    private $phpDocParser;
    public function __construct(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Reflection\PrivatesCaller $privatesCaller)
    {
        $this->privatesCaller = $privatesCaller;
    }
    public function createFromTokens(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : ?\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
    {
        try {
            $tokenIterator->pushSavePoint();
            $attributeAwareDataProviderTagValueNode = $this->parseDataProviderTagValue($tokenIterator);
            $tokenIterator->dropSavePoint();
            return $attributeAwareDataProviderTagValueNode;
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
    private function parseDataProviderTagValue(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\TokenIterator $tokenIterator) : \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\DataProviderTagValueNode
    {
        $method = $this->privatesCaller->callPrivateMethod($this->phpDocParser, 'parseOptionalDescription', $tokenIterator);
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\DataProviderTagValueNode($method);
    }
}
