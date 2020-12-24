<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\VendorLocker\NodeVendorLocker;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScoperb75b35f52b74\Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function autowireAbstractNodeVendorLockResolver(\_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer $familyRelationsAnalyzer) : void
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->classManipulator = $classManipulator;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->familyRelationsAnalyzer = $familyRelationsAnalyzer;
    }
    protected function hasParentClassChildrenClassesOrImplementsInterface(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike) : bool
    {
        if (($classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ || $classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_) && $classLike->extends) {
            return \true;
        }
        if ($classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
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
    protected function isMethodVendorLockedByInterface(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike, string $methodName) : bool
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
    protected function getChildrenClassesByClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $desiredClassName = $class->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
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
