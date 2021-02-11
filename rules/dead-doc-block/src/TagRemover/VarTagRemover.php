<?php

declare (strict_types=1);
namespace Rector\DeadDocBlock\TagRemover;

use PhpParser\Node;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\Type\Type;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\DeadDocBlock\DeadVarTagValueNodeAnalyzer;
use Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer;
use Rector\StaticTypeMapper\StaticTypeMapper;
use RectorPrefix20210211\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
final class VarTagRemover
{
    /**
     * @var DoctrineTypeAnalyzer
     */
    private $doctrineTypeAnalyzer;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @var ClassLikeExistenceChecker
     */
    private $classLikeExistenceChecker;
    /**
     * @var DeadVarTagValueNodeAnalyzer
     */
    private $deadVarTagValueNodeAnalyzer;
    public function __construct(\Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer $doctrineTypeAnalyzer, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \RectorPrefix20210211\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker $classLikeExistenceChecker, \Rector\DeadDocBlock\DeadVarTagValueNodeAnalyzer $deadVarTagValueNodeAnalyzer)
    {
        $this->doctrineTypeAnalyzer = $doctrineTypeAnalyzer;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->classLikeExistenceChecker = $classLikeExistenceChecker;
        $this->deadVarTagValueNodeAnalyzer = $deadVarTagValueNodeAnalyzer;
    }
    public function removeVarTagIfUseless(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \PhpParser\Node\Stmt\Property $property) : void
    {
        $varTagValueNode = $phpDocInfo->getVarTagValueNode();
        if (!$varTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode) {
            return;
        }
        $isVarTagValueDead = $this->deadVarTagValueNodeAnalyzer->isDead($varTagValueNode, $property);
        if (!$isVarTagValueDead) {
            return;
        }
        $phpDocInfo->removeByType(\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class);
    }
    /**
     * @param Property|Param $node
     */
    public function removeVarPhpTagValueNodeIfNotComment(\PhpParser\Node $node, \PHPStan\Type\Type $type) : void
    {
        // keep doctrine collection narrow type
        if ($this->doctrineTypeAnalyzer->isDoctrineCollectionWithIterableUnionType($type)) {
            return;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        $varTagValueNode = $phpDocInfo->getVarTagValueNode();
        if (!$varTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode) {
            return;
        }
        // has description? keep it
        if ($varTagValueNode->description !== '') {
            return;
        }
        // keep generic types
        if ($varTagValueNode->type instanceof \PHPStan\PhpDocParser\Ast\Type\GenericTypeNode) {
            return;
        }
        // keep string[] etc.
        if ($this->isNonBasicArrayType($node, $varTagValueNode)) {
            return;
        }
        $phpDocInfo->removeByType(\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class);
    }
    /**
     * @param Param|Property $node
     */
    private function isNonBasicArrayType(\PhpParser\Node $node, \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode $varTagValueNode) : bool
    {
        if ($varTagValueNode->type instanceof \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode) {
            foreach ($varTagValueNode->type->types as $type) {
                if ($type instanceof \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode && $this->classLikeExistenceChecker->doesClassLikeExist((string) $type->type)) {
                    return \true;
                }
            }
        }
        if (!$this->isArrayTypeNode($varTagValueNode)) {
            return \false;
        }
        $varTypeDocString = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPhpDocString($varTagValueNode->type, $node);
        return $varTypeDocString !== 'array';
    }
    private function isArrayTypeNode(\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode $varTagValueNode) : bool
    {
        return $varTagValueNode->type instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
    }
}
