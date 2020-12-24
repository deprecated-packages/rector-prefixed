<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\NodeFactory;

use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Core\Php\PhpVersionProvider;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->phpVersionProvider = $phpVersionProvider;
        $this->staticTypeMapper = $staticTypeMapper;
    }
    public function decorateProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $propertyType) : void
    {
        $this->decoratePropertyWithVarDoc($property, $propertyType);
        $this->decoratePropertyWithType($property, $propertyType);
    }
    private function decoratePropertyWithVarDoc(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $propertyType) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($this->isNonMixedArrayType($propertyType)) {
            $phpDocInfo->changeVarType($propertyType);
            $property->type = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier('array');
            return;
        }
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES)) {
            $phpParserNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($propertyType);
            if ($phpParserNode === null) {
                // fallback to doc type in PHP 7.4
                $phpDocInfo->changeVarType($propertyType);
            }
        } else {
            $phpDocInfo->changeVarType($propertyType);
        }
    }
    private function decoratePropertyWithType(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $propertyType) : void
    {
        if (!$this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES)) {
            return;
        }
        $phpParserNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($propertyType);
        if ($phpParserNode === null) {
            return;
        }
        $property->type = $phpParserNode;
    }
    private function isNonMixedArrayType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
            return \false;
        }
        if ($type->getKeyType() instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return \false;
        }
        return !$type->getItemType() instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
    }
}
