<?php

declare (strict_types=1);
namespace Rector\Renaming\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\UseUse;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocClassRenamer;
use Rector\BetterPhpDocParser\ValueObject\NodeTypes;
use Rector\CodingStyle\Naming\ClassNaming;
use Rector\Core\Configuration\Option;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeRemoval\NodeRemover;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer;
use Rector\NodeTypeResolver\ValueObject\OldToNewType;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
use RectorPrefix20210408\Symplify\PackageBuilder\Parameter\ParameterProvider;
final class ClassRenamer
{
    /**
     * @var string[]
     */
    private $alreadyProcessedClasses = [];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
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
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @var DocBlockClassRenamer
     */
    private $docBlockClassRenamer;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var NodeRemover
     */
    private $nodeRemover;
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\CodingStyle\Naming\ClassNaming $classNaming, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocClassRenamer $phpDocClassRenamer, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer $docBlockClassRenamer, \PHPStan\Reflection\ReflectionProvider $reflectionProvider, \Rector\NodeRemoval\NodeRemover $nodeRemover, \RectorPrefix20210408\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->phpDocClassRenamer = $phpDocClassRenamer;
        $this->classNaming = $classNaming;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->docBlockClassRenamer = $docBlockClassRenamer;
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeRemover = $nodeRemover;
        $this->parameterProvider = $parameterProvider;
    }
    /**
     * @param array<string, string> $oldToNewClasses
     */
    public function renameNode(\PhpParser\Node $node, array $oldToNewClasses) : ?\PhpParser\Node
    {
        $oldToNewTypes = [];
        foreach ($oldToNewClasses as $oldClass => $newClass) {
            $oldToNewTypes[] = new \Rector\NodeTypeResolver\ValueObject\OldToNewType(new \PHPStan\Type\ObjectType($oldClass), new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($newClass));
        }
        $this->refactorPhpDoc($node, $oldToNewTypes, $oldToNewClasses);
        if ($node instanceof \PhpParser\Node\Name) {
            return $this->refactorName($node, $oldToNewClasses);
        }
        if ($node instanceof \PhpParser\Node\Stmt\Namespace_) {
            return $this->refactorNamespace($node, $oldToNewClasses);
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassLike) {
            return $this->refactorClassLike($node, $oldToNewClasses);
        }
        return null;
    }
    /**
     * @param OldToNewType[] $oldToNewTypes
     * @param array<string, string> $oldToNewClasses
     */
    private function refactorPhpDoc(\PhpParser\Node $node, array $oldToNewTypes, array $oldToNewClasses) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        if (!$phpDocInfo->hasByTypes(\Rector\BetterPhpDocParser\ValueObject\NodeTypes::TYPE_AWARE_NODES) && !$phpDocInfo->hasByAnnotationClasses(\Rector\BetterPhpDocParser\ValueObject\NodeTypes::TYPE_AWARE_DOCTRINE_ANNOTATION_CLASSES)) {
            return;
        }
        $this->docBlockClassRenamer->renamePhpDocType($phpDocInfo, $oldToNewTypes);
        $this->phpDocClassRenamer->changeTypeInAnnotationTypes($node, $phpDocInfo, $oldToNewClasses);
    }
    /**
     * @param array<string, string> $oldToNewClasses
     */
    private function refactorName(\PhpParser\Node\Name $name, array $oldToNewClasses) : ?\PhpParser\Node\Name
    {
        $stringName = $this->nodeNameResolver->getName($name);
        $newName = $oldToNewClasses[$stringName] ?? null;
        if (!$newName) {
            return null;
        }
        if (!$this->isClassToInterfaceValidChange($name, $newName)) {
            return null;
        }
        $parentNode = $name->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // no need to preslash "use \SomeNamespace" of imported namespace
        if ($parentNode instanceof \PhpParser\Node\Stmt\UseUse && ($parentNode->type === \PhpParser\Node\Stmt\Use_::TYPE_NORMAL || $parentNode->type === \PhpParser\Node\Stmt\Use_::TYPE_UNKNOWN)) {
            // no need to rename imports, they will be handled by autoimport and coding standard
            // also they might cause some rename
            return null;
        }
        $last = $name->getLast();
        $newFullyQualified = new \PhpParser\Node\Name\FullyQualified($newName);
        $newNameLastName = $newFullyQualified->getLast();
        $importNames = $this->parameterProvider->provideBoolParameter(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES);
        if ($this->shouldRemoveUseName($last, $newNameLastName, $importNames)) {
            $this->removeUseName($name);
        }
        return new \PhpParser\Node\Name\FullyQualified($newName);
    }
    private function removeUseName(\PhpParser\Node\Name $oldName) : void
    {
        $uses = $this->betterNodeFinder->findFirstPreviousOfNode($oldName, function (\PhpParser\Node $node) use($oldName) : bool {
            return $node instanceof \PhpParser\Node\Stmt\UseUse && $this->nodeNameResolver->areNamesEqual($node, $oldName);
        });
        if (!$uses instanceof \PhpParser\Node\Stmt\UseUse) {
            return;
        }
        if ($uses->alias !== null) {
            return;
        }
        // ios the only one? Remove whole use instead to avoid "use ;" constructions
        $parentUse = $uses->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentUse instanceof \PhpParser\Node\Stmt\Use_ && \count($parentUse->uses) === 1) {
            $this->nodeRemover->removeNode($parentUse);
        } else {
            $this->nodeRemover->removeNode($uses);
        }
    }
    /**
     * @param array<string, string> $oldToNewClasses
     */
    private function refactorNamespace(\PhpParser\Node\Stmt\Namespace_ $namespace, array $oldToNewClasses) : ?\PhpParser\Node
    {
        $name = $this->nodeNameResolver->getName($namespace);
        if ($name === null) {
            return null;
        }
        $classLike = $this->getClassOfNamespaceToRefactor($namespace, $oldToNewClasses);
        if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike) {
            return null;
        }
        $currentName = $this->nodeNameResolver->getName($classLike);
        $newClassFullyQualified = $oldToNewClasses[$currentName];
        if ($this->reflectionProvider->hasClass($newClassFullyQualified)) {
            return null;
        }
        $newNamespace = $this->classNaming->getNamespace($newClassFullyQualified);
        // Renaming to class without namespace (example MyNamespace\DateTime -> DateTimeImmutable)
        if (!$newNamespace) {
            $classLike->name = new \PhpParser\Node\Identifier($newClassFullyQualified);
            return $classLike;
        }
        $namespace->name = new \PhpParser\Node\Name($newNamespace);
        return $namespace;
    }
    /**
     * @param array<string, string> $oldToNewClasses
     */
    private function refactorClassLike(\PhpParser\Node\Stmt\ClassLike $classLike, array $oldToNewClasses) : ?\PhpParser\Node
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
        $this->alreadyProcessedClasses[] = $name;
        $newName = $oldToNewClasses[$name];
        $newClassNamePart = $this->nodeNameResolver->getShortName($newName);
        $newNamespacePart = $this->classNaming->getNamespace($newName);
        if ($this->isClassAboutToBeDuplicated($newName)) {
            return null;
        }
        $classLike->name = new \PhpParser\Node\Identifier($newClassNamePart);
        $classNamingGetNamespace = $this->classNaming->getNamespace($name);
        // Old class did not have any namespace, we need to wrap class with Namespace_ node
        if ($newNamespacePart && !$classNamingGetNamespace) {
            $this->changeNameToFullyQualifiedName($classLike);
            $nameNode = new \PhpParser\Node\Name($newNamespacePart);
            return new \PhpParser\Node\Stmt\Namespace_($nameNode, [$classLike]);
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
    private function isClassToInterfaceValidChange(\PhpParser\Node\Name $name, string $newClassName) : bool
    {
        if (!$this->reflectionProvider->hasClass($newClassName)) {
            return \true;
        }
        $classReflection = $this->reflectionProvider->getClass($newClassName);
        // ensure new is not with interface
        $parentNode = $name->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \PhpParser\Node\Expr\New_ && $classReflection->isInterface()) {
            return \false;
        }
        if ($parentNode instanceof \PhpParser\Node\Stmt\Class_) {
            return $this->isValidClassNameChange($name, $parentNode, $classReflection);
        }
        // prevent to change to import, that already exists
        if ($parentNode instanceof \PhpParser\Node\Stmt\UseUse) {
            return $this->isValidUseImportChange($newClassName, $parentNode);
        }
        return \true;
    }
    /**
     * @param array<string, string> $oldToNewClasses
     */
    private function getClassOfNamespaceToRefactor(\PhpParser\Node\Stmt\Namespace_ $namespace, array $oldToNewClasses) : ?\PhpParser\Node\Stmt\ClassLike
    {
        $foundClass = $this->betterNodeFinder->findFirst($namespace, function (\PhpParser\Node $node) use($oldToNewClasses) : bool {
            if (!$node instanceof \PhpParser\Node\Stmt\ClassLike) {
                return \false;
            }
            $classLikeName = $this->nodeNameResolver->getName($node);
            return isset($oldToNewClasses[$classLikeName]);
        });
        return $foundClass instanceof \PhpParser\Node\Stmt\ClassLike ? $foundClass : null;
    }
    /**
     * @param string[] $oldToNewClasses
     */
    private function renameClassImplements(\PhpParser\Node\Stmt\ClassLike $classLike, array $oldToNewClasses) : void
    {
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return;
        }
        /** @var Scope|null $scope */
        $scope = $classLike->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        $classLike->implements = \array_unique($classLike->implements);
        foreach ($classLike->implements as $key => $implementName) {
            $virtualNode = $implementName->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::VIRTUAL_NODE);
            if (!$virtualNode) {
                continue;
            }
            $namespaceName = $scope instanceof \PHPStan\Analyser\Scope ? $scope->getNamespace() : null;
            $fullyQualifiedName = $namespaceName . '\\' . $implementName->toString();
            $newName = $oldToNewClasses[$fullyQualifiedName] ?? null;
            if ($newName === null) {
                continue;
            }
            $classLike->implements[$key] = new \PhpParser\Node\Name\FullyQualified($newName);
        }
    }
    private function isClassAboutToBeDuplicated(string $newName) : bool
    {
        return $this->reflectionProvider->hasClass($newName);
    }
    private function changeNameToFullyQualifiedName(\PhpParser\Node\Stmt\ClassLike $classLike) : void
    {
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($classLike, function (\PhpParser\Node $node) {
            if (!$node instanceof \PhpParser\Node\Name\FullyQualified) {
                return null;
            }
            // invoke override
            $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        });
    }
    private function isValidClassNameChange(\PhpParser\Node\Name $name, \PhpParser\Node\Stmt\Class_ $class, \PHPStan\Reflection\ClassReflection $classReflection) : bool
    {
        if ($class->extends === $name) {
            // is class to interface?
            if ($classReflection->isInterface()) {
                return \false;
            }
            if ($classReflection->isFinalByKeyword()) {
                return \false;
            }
        }
        // is interface to class?
        return !(\in_array($name, $class->implements, \true) && $classReflection->isClass());
    }
    private function isValidUseImportChange(string $newName, \PhpParser\Node\Stmt\UseUse $useUse) : bool
    {
        /** @var Use_[]|null $useNodes */
        $useNodes = $useUse->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES);
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
    private function shouldRemoveUseName(string $last, string $newNameLastName, bool $importNames) : bool
    {
        return $last === $newNameLastName && $importNames;
    }
}
