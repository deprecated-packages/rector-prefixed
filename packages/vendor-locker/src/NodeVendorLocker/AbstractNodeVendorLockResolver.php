<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\VendorLocker\NodeVendorLocker;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScopere8e811afab72\Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function autowireAbstractNodeVendorLockResolver(\_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer $familyRelationsAnalyzer) : void
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->classManipulator = $classManipulator;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->familyRelationsAnalyzer = $familyRelationsAnalyzer;
    }
    protected function hasParentClassChildrenClassesOrImplementsInterface(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : bool
    {
        if (($classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ || $classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_) && $classLike->extends) {
            return \true;
        }
        if ($classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
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
    protected function isMethodVendorLockedByInterface(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike, string $methodName) : bool
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
    protected function getChildrenClassesByClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $desiredClassName = $class->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
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
