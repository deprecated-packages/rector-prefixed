<?php

declare (strict_types=1);
namespace Rector\DeadCode\NodeAnalyzer;

use PhpParser\Node\Stmt\Class_;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\PHPUnit\PhpDoc\Node\PHPUnitDataProviderTagValueNode;
final class DataProviderMethodNamesResolver
{
    /**
     * @var array<string, string[]>
     */
    private $cachedDataProviderMethodNamesByClassHash = [];
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function resolveFromClass(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $classKey = \spl_object_hash($class);
        if (isset($this->cachedDataProviderMethodNamesByClassHash[$classKey])) {
            return $this->cachedDataProviderMethodNamesByClassHash[$classKey];
        }
        $dataProviderMethodNames = [];
        $phpunitDataProviderTagValueNodes = $this->resolvePHPUnitDataProviderTagValueNodes($class);
        foreach ($phpunitDataProviderTagValueNodes as $phpunitDataProviderTagValueNode) {
            $dataProviderMethodNames[] = $phpunitDataProviderTagValueNode->getMethodName();
        }
        $this->cachedDataProviderMethodNamesByClassHash[$classKey] = $dataProviderMethodNames;
        return $dataProviderMethodNames;
    }
    /**
     * @return PHPUnitDataProviderTagValueNode[]
     */
    private function resolvePHPUnitDataProviderTagValueNodes(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        if (!$this->nodeTypeResolver->isObjectType($class, new \PHPStan\Type\ObjectType('PHPUnit\\Framework\\TestCase'))) {
            return [];
        }
        $phpunitDataProviderTagValueNodes = [];
        foreach ($class->getMethods() as $classMethod) {
            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
            $foundPHPUnitDataProviderTagValueNodes = $phpDocInfo->findAllByType(\Rector\PHPUnit\PhpDoc\Node\PHPUnitDataProviderTagValueNode::class);
            $phpunitDataProviderTagValueNodes = \array_merge($phpunitDataProviderTagValueNodes, $foundPHPUnitDataProviderTagValueNodes);
        }
        return $phpunitDataProviderTagValueNodes;
    }
}
