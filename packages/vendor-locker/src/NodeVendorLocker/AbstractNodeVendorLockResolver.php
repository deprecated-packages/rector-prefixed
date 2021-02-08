<?php

declare (strict_types=1);
namespace Rector\VendorLocker\NodeVendorLocker;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Interface_;
use Rector\Core\NodeManipulator\ClassManipulator;
use Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractNodeVendorLockResolver
{
    /**
     * @var ClassManipulator
     */
    protected $classManipulator;
    /**
     * @var NodeNameResolver
     */
    protected $nodeNameResolver;
    /**
     * @var NodeRepository
     */
    protected $nodeRepository;
    /**
     * @var FamilyRelationsAnalyzer
     */
    private $familyRelationsAnalyzer;
    /**
     * @required
     */
    public function autowireAbstractNodeVendorLockResolver(\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \Rector\Core\NodeManipulator\ClassManipulator $classManipulator, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer $familyRelationsAnalyzer) : void
    {
        $this->nodeRepository = $nodeRepository;
        $this->classManipulator = $classManipulator;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->familyRelationsAnalyzer = $familyRelationsAnalyzer;
    }
    protected function hasParentClassChildrenClassesOrImplementsInterface(\PhpParser\Node\Stmt\ClassLike $classLike) : bool
    {
        if (($classLike instanceof \PhpParser\Node\Stmt\Class_ || $classLike instanceof \PhpParser\Node\Stmt\Interface_) && $classLike->extends) {
            return \true;
        }
        if ($classLike instanceof \PhpParser\Node\Stmt\Class_) {
            if ((bool) $classLike->implements) {
                return \true;
            }
            /** @var Class_ $classLike */
            return $this->getChildrenClassesByClass($classLike) !== [];
        }
        return \false;
    }
    /**
     * @param Class_|Interface_ $classLike
     */
    protected function isMethodVendorLockedByInterface(\PhpParser\Node\Stmt\ClassLike $classLike, string $methodName) : bool
    {
        $interfaceNames = $this->classManipulator->getClassLikeNodeParentInterfaceNames($classLike);
        foreach ($interfaceNames as $interfaceName) {
            if (!$this->hasInterfaceMethod($methodName, $interfaceName)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    /**
     * @return class-string[]
     */
    protected function getChildrenClassesByClass(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $desiredClassName = $class->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($desiredClassName === null) {
            return [];
        }
        return $this->familyRelationsAnalyzer->getChildrenOfClass($desiredClassName);
    }
    private function hasInterfaceMethod(string $methodName, string $interfaceName) : bool
    {
        if (!\interface_exists($interfaceName)) {
            return \false;
        }
        $interfaceMethods = \get_class_methods($interfaceName);
        return \in_array($methodName, $interfaceMethods, \true);
    }
}
