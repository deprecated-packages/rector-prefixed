<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\NodeManipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScopere8e811afab72\Rector\Core\PhpDoc\PhpDocClassRenamer;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
final class ClassRenamer
{
    /**
     * @var string[]
     */
    private $alreadyProcessedClasses = [];
    /**
     * @var DocBlockManipulator
     */
    private $docBlockManipulator;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var PhpDocClassRenamer
     */
    private $phpDocClassRenamer;
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator $docBlockManipulator, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\Core\PhpDoc\PhpDocClassRenamer $phpDocClassRenamer)
    {
        $this->docBlockManipulator = $docBlockManipulator;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->phpDocClassRenamer = $phpDocClassRenamer;
        $this->classNaming = $classNaming;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    /**
     * @param array<string, string> $oldToNewClasses
     */
    public function renameNode(\_PhpScopere8e811afab72\PhpParser\Node $node, array $oldToNewClasses) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $this->refactorPhpDoc($node, $oldToNewClasses);
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            return $this->refactorName($node, $oldToNewClasses);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_) {
            return $this->refactorNamespace($node, $oldToNewClasses);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
            return $this->refactorClassLike($node, $oldToNewClasses);
        }
        return null;
    }
    /**
     * Replace types in @var/@param/@return/@throws,
     * Doctrine @ORM entity targetClass, Serialize, Assert etc.
     *
     * @param array<string, string> $oldToNewClasses
     */
    private function refactorPhpDoc(\_PhpScopere8e811afab72\PhpParser\Node $node, array $oldToNewClasses) : void
    {
        if (!$this->docBlockManipulator->hasNodeTypeTags($node)) {
            return;
        }
        foreach ($oldToNewClasses as $oldClass => $newClass) {
            $oldClassType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($oldClass);
            $newClassType = new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($newClass);
            $this->docBlockManipulator->changeType($node, $oldClassType, $newClassType);
        }
        $this->phpDocClassRenamer->changeTypeInAnnotationTypes($node, $oldToNewClasses);
    }
    /**
     * @param array<string, string> $oldToNewClasses
     */
    private function refactorName(\_PhpScopere8e811afab72\PhpParser\Node\Name $name, array $oldToNewClasses) : ?\_PhpScopere8e811afab72\PhpParser\Node\Name
    {
        $stringName = $this->nodeNameResolver->getName($name);
        $newName = $oldToNewClasses[$stringName] ?? null;
        if (!$newName) {
            return null;
        }
        if (!$this->isClassToInterfaceValidChange($name, $newName)) {
            return null;
        }
        $parentNode = $name->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // no need to preslash "use \SomeNamespace" of imported namespace
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse && ($parentNode->type === \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_::TYPE_NORMAL || $parentNode->type === \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_::TYPE_UNKNOWN)) {
            $name = new \_PhpScopere8e811afab72\PhpParser\Node\Name($newName);
        } else {
            $name = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($newName);
        }
        $name->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $parentNode);
        return $name;
    }
    /**
     * @param array<string, string> $oldToNewClasses
     */
    private function refactorNamespace(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ $namespace, array $oldToNewClasses) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $name = $this->nodeNameResolver->getName($namespace);
        if ($name === null) {
            return null;
        }
        $classLike = $this->getClassOfNamespaceToRefactor($namespace, $oldToNewClasses);
        if ($classLike === null) {
            return null;
        }
        $currentName = $this->nodeNameResolver->getName($classLike);
        $newClassFqn = $oldToNewClasses[$currentName];
        $newNamespace = $this->classNaming->getNamespace($newClassFqn);
        // Renaming to class without namespace (example MyNamespace\DateTime -> DateTimeImmutable)
        if (!$newNamespace) {
            $classLike->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($newClassFqn);
            return $classLike;
        }
        $namespace->name = new \_PhpScopere8e811afab72\PhpParser\Node\Name($newNamespace);
        return $namespace;
    }
    /**
     * @param array<string, string> $oldToNewClasses
     */
    private function refactorClassLike(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike, array $oldToNewClasses) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        // rename interfaces
        $this->renameClassImplements($classLike, $oldToNewClasses);
        $name = $this->nodeNameResolver->getName($classLike);
        if ($name === null) {
            return null;
        }
        $newName = $oldToNewClasses[$name] ?? null;
        if (!$newName) {
            return null;
        }
        // prevents re-iterating same class in endless loop
        if (\in_array($name, $this->alreadyProcessedClasses, \true)) {
            return null;
        }
        /** @var string $name */
        $this->alreadyProcessedClasses[] = $name;
        $newName = $oldToNewClasses[$name];
        $newClassNamePart = $this->classNaming->getShortName($newName);
        $newNamespacePart = $this->classNaming->getNamespace($newName);
        if ($this->isClassAboutToBeDuplicated($newName)) {
            return null;
        }
        $classLike->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($newClassNamePart);
        $classNamingGetNamespace = $this->classNaming->getNamespace($name);
        // Old class did not have any namespace, we need to wrap class with Namespace_ node
        if ($newNamespacePart && !$classNamingGetNamespace) {
            $this->changeNameToFullyQualifiedName($classLike);
            $nameNode = new \_PhpScopere8e811afab72\PhpParser\Node\Name($newNamespacePart);
            $namespace = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_($nameNode, [$classLike]);
            $nameNode->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $namespace);
            return $namespace;
        }
        return $classLike;
    }
    /**
     * Checks validity:
     *
     * - extends SomeClass
     * - extends SomeInterface
     *
     * - new SomeClass
     * - new SomeInterface
     *
     * - implements SomeInterface
     * - implements SomeClass
     */
    private function isClassToInterfaceValidChange(\_PhpScopere8e811afab72\PhpParser\Node\Name $name, string $newName) : bool
    {
        // ensure new is not with interface
        $parentNode = $name->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ && \interface_exists($newName)) {
            return \false;
        }
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return $this->isValidClassNameChange($name, $newName, $parentNode);
        }
        // prevent to change to import, that already exists
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse) {
            return $this->isValidUseImportChange($newName, $parentNode);
        }
        return \true;
    }
    /**
     * @param array<string, string> $oldToNewClasses
     */
    private function getClassOfNamespaceToRefactor(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ $namespace, array $oldToNewClasses) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike
    {
        $foundClass = $this->betterNodeFinder->findFirst($namespace, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($oldToNewClasses) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
                return \false;
            }
            $classLikeName = $this->nodeNameResolver->getName($node);
            return isset($oldToNewClasses[$classLikeName]);
        });
        return $foundClass instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike ? $foundClass : null;
    }
    /**
     * @param string[] $oldToNewClasses
     */
    private function renameClassImplements(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike, array $oldToNewClasses) : void
    {
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return;
        }
        foreach ((array) $classLike->implements as $key => $implementName) {
            if (!$implementName instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
                continue;
            }
            $virtualNode = $implementName->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::VIRTUAL_NODE);
            if (!$virtualNode) {
                continue;
            }
            $namespaceName = $classLike->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME);
            $fullyQualifiedName = $namespaceName . '\\' . $implementName->toString();
            $newName = $oldToNewClasses[$fullyQualifiedName] ?? null;
            if ($newName === null) {
                continue;
            }
            $classLike->implements[$key] = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($newName);
        }
    }
    private function isClassAboutToBeDuplicated(string $newName) : bool
    {
        return \_PhpScopere8e811afab72\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($newName);
    }
    private function changeNameToFullyQualifiedName(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike, function (\_PhpScopere8e811afab72\PhpParser\Node $node) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified) {
                return null;
            }
            // invoke override
            $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        });
    }
    private function isValidClassNameChange(\_PhpScopere8e811afab72\PhpParser\Node\Name $name, string $newName, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($class->extends === $name && \interface_exists($newName)) {
            return \false;
        }
        return !(\in_array($name, $class->implements, \true) && \class_exists($newName));
    }
    private function isValidUseImportChange(string $newName, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse $useUse) : bool
    {
        /** @var Use_[]|null $useNodes */
        $useNodes = $useUse->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES);
        if ($useNodes === null) {
            return \true;
        }
        foreach ($useNodes as $useNode) {
            if ($this->nodeNameResolver->isName($useNode, $newName)) {
                // name already exists
                return \false;
            }
        }
        return \true;
    }
}
