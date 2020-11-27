<?php

declare (strict_types=1);
namespace Rector\VendorLocker\NodeVendorLocker;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Interface_;
use Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer;
use Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractNodeVendorLockResolver
{
    /**
     * @var ParsedNodeCollector
     */
    protected $parsedNodeCollector;
    /**
     * @var ClassManipulator
     */
    protected $classManipulator;
    /**
     * @var NodeNameResolver
     */
    protected $nodeNameResolver;
    /**
     * @var FamilyRelationsAnalyzer
     */
    private $familyRelationsAnalyzer;
    /**
     * @required
     */
    public function autowireAbstractNodeVendorLockResolver(\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer $familyRelationsAnalyzer) : void
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
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
