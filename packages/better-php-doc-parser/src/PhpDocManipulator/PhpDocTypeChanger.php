<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocManipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NeverType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareReturnTagValueNode;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\ChangesReporting\Collector\RectorChangeCollector;
use _PhpScoper0a6b37af0871\Rector\Core\Configuration\CurrentNodeProvider;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\TypeComparator;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\PhpDocParser\ParamPhpDocNodeFactory;
final class PhpDocTypeChanger
{
    /**
     * @var TypeComparator
     */
    private $typeComparator;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var ParamPhpDocNodeFactory
     */
    private $paramPhpDocNodeFactory;
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    /**
     * @var CurrentNodeProvider
     */
    private $currentNodeProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\PhpDocParser\ParamPhpDocNodeFactory $paramPhpDocNodeFactory, \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\TypeComparator $typeComparator, \_PhpScoper0a6b37af0871\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector, \_PhpScoper0a6b37af0871\Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider)
    {
        $this->typeComparator = $typeComparator;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->paramPhpDocNodeFactory = $paramPhpDocNodeFactory;
        $this->rectorChangeCollector = $rectorChangeCollector;
        $this->currentNodeProvider = $currentNodeProvider;
    }
    public function changeVarType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $newType) : void
    {
        // make sure the tags are not identical, e.g imported class vs FQN class
        if ($this->typeComparator->areTypesEqual($phpDocInfo->getVarType(), $newType)) {
            return;
        }
        // prevent existing type override by mixed
        if (!$phpDocInfo->getVarType() instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType && $newType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType && $newType->getItemType() instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType) {
            return;
        }
        // override existing type
        $newPHPStanPhpDocType = $this->staticTypeMapper->mapPHPStanTypeToPHPStanPhpDocTypeNode($newType);
        $currentVarTagValueNode = $phpDocInfo->getVarTagValueNode();
        if ($currentVarTagValueNode !== null) {
            // only change type
            $currentVarTagValueNode->type = $newPHPStanPhpDocType;
        } else {
            // add completely new one
            $attributeAwareVarTagValueNode = new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareVarTagValueNode($newPHPStanPhpDocType, '', '');
            $phpDocInfo->addTagValueNode($attributeAwareVarTagValueNode);
        }
        // notify about node change
        $this->notifyChange();
    }
    public function changeReturnType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $newType) : void
    {
        // make sure the tags are not identical, e.g imported class vs FQN class
        if ($this->typeComparator->areTypesEqual($phpDocInfo->getReturnType(), $newType)) {
            return;
        }
        // override existing type
        $newPHPStanPhpDocType = $this->staticTypeMapper->mapPHPStanTypeToPHPStanPhpDocTypeNode($newType);
        $currentReturnTagValueNode = $phpDocInfo->getReturnTagValue();
        if ($currentReturnTagValueNode !== null) {
            // only change type
            $currentReturnTagValueNode->type = $newPHPStanPhpDocType;
        } else {
            // add completely new one
            $attributeAwareReturnTagValueNode = new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareReturnTagValueNode($newPHPStanPhpDocType, '');
            $phpDocInfo->addTagValueNode($attributeAwareReturnTagValueNode);
        }
        // notify about node change
        $this->notifyChange();
    }
    public function changeParamType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $newType, \_PhpScoper0a6b37af0871\PhpParser\Node\Param $param, string $paramName) : void
    {
        $phpDocType = $this->staticTypeMapper->mapPHPStanTypeToPHPStanPhpDocTypeNode($newType);
        $paramTagValueNode = $phpDocInfo->getParamTagValueByName($paramName);
        // override existing type
        if ($paramTagValueNode !== null) {
            // already set
            $currentType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($paramTagValueNode->type, $param);
            if ($this->typeComparator->areTypesEqual($currentType, $newType)) {
                return;
            }
            $paramTagValueNode->type = $phpDocType;
        } else {
            $paramTagValueNode = $this->paramPhpDocNodeFactory->create($phpDocType, $param);
            $phpDocInfo->addTagValueNode($paramTagValueNode);
        }
        // notify about node change
        $this->notifyChange();
    }
    private function notifyChange() : void
    {
        $node = $this->currentNodeProvider->getNode();
        if ($node === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->rectorChangeCollector->notifyNodeFileInfo($node);
    }
}
