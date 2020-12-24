<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\Php\PhpVersionProvider;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper;
final class PropertyTypeDecorator
{
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->phpVersionProvider = $phpVersionProvider;
        $this->staticTypeMapper = $staticTypeMapper;
    }
    public function decorateProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $propertyType) : void
    {
        $this->decoratePropertyWithVarDoc($property, $propertyType);
        $this->decoratePropertyWithType($property, $propertyType);
    }
    private function decoratePropertyWithVarDoc(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $propertyType) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($this->isNonMixedArrayType($propertyType)) {
            $phpDocInfo->changeVarType($propertyType);
            $property->type = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier('array');
            return;
        }
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES)) {
            $phpParserNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($propertyType);
            if ($phpParserNode === null) {
                // fallback to doc type in PHP 7.4
                $phpDocInfo->changeVarType($propertyType);
            }
        } else {
            $phpDocInfo->changeVarType($propertyType);
        }
    }
    private function decoratePropertyWithType(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $propertyType) : void
    {
        if (!$this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES)) {
            return;
        }
        $phpParserNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($propertyType);
        if ($phpParserNode === null) {
            return;
        }
        $property->type = $phpParserNode;
    }
    private function isNonMixedArrayType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
            return \false;
        }
        if ($type->getKeyType() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return \false;
        }
        return !$type->getItemType() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
    }
}
