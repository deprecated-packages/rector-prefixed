<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\VendorLocker\NodeVendorLocker;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScoper0a6b37af0871\Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function autowireAbstractNodeVendorLockResolver(\_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer $familyRelationsAnalyzer) : void
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->classManipulator = $classManipulator;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->familyRelationsAnalyzer = $familyRelationsAnalyzer;
    }
    protected function hasParentClassChildrenClassesOrImplementsInterface(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike) : bool
    {
        if (($classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ || $classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_) && $classLike->extends) {
            return \true;
        }
        if ($classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
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
    protected function isMethodVendorLockedByInterface(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike, string $methodName) : bool
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
    protected function getChildrenClassesByClass(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $desiredClassName = $class->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
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
