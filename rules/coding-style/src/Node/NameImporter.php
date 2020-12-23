<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\Node;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\ClassNameImport\AliasUsesResolver;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipper;
use _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoper0a2ac50786fa\Rector\PostRector\Collector\UseNodesToAddCollector;
use _PhpScoper0a2ac50786fa\Rector\PSR4\Collector\RenamedClassesCollector;
use _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider;
final class NameImporter
{
    /**
     * @var string[]
     */
    private $aliasedUses = [];
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var AliasUsesResolver
     */
    private $aliasUsesResolver;
    /**
     * @var ClassNameImportSkipper
     */
    private $classNameImportSkipper;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @var UseNodesToAddCollector
     */
    private $useNodesToAddCollector;
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\CodingStyle\ClassNameImport\AliasUsesResolver $aliasUsesResolver, \_PhpScoper0a2ac50786fa\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipper $classNameImportSkipper, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoper0a2ac50786fa\Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector, \_PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoper0a2ac50786fa\Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->aliasUsesResolver = $aliasUsesResolver;
        $this->classNameImportSkipper = $classNameImportSkipper;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->parameterProvider = $parameterProvider;
        $this->useNodesToAddCollector = $useNodesToAddCollector;
        $this->renamedClassesCollector = $renamedClassesCollector;
    }
    public function importName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $name) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Name
    {
        if ($this->shouldSkipName($name)) {
            return null;
        }
        if ($this->classNameImportSkipper->isShortNameInUseStatement($name)) {
            return null;
        }
        $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($name);
        if (!$staticType instanceof \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            return null;
        }
        $this->aliasedUses = $this->aliasUsesResolver->resolveForNode($name);
        return $this->importNameAndCollectNewUseStatement($name, $staticType);
    }
    private function shouldSkipName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $name) : bool
    {
        $virtualNode = $name->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::VIRTUAL_NODE);
        if ($virtualNode) {
            return \true;
        }
        // is scalar name?
        if (\in_array($name->toLowerString(), ['true', 'false', 'bool'], \true)) {
            return \true;
        }
        // namespace <name>
        // use <name>;
        if ($this->isNamespaceOrUseImportName($name)) {
            return \true;
        }
        if ($this->isFunctionOrConstantImportWithSingleName($name)) {
            return \true;
        }
        if ($this->isNonExistingClassLikeAndFunctionFullyQualifiedName($name)) {
            return \true;
        }
        // Importing root namespace classes (like \DateTime) is optional
        $importShortClasses = $this->parameterProvider->provideParameter(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::IMPORT_SHORT_CLASSES);
        if (!$importShortClasses) {
            $name = $this->nodeNameResolver->getName($name);
            if ($name !== null && \substr_count($name, '\\') === 0) {
                return \true;
            }
        }
        return \false;
    }
    private function importNameAndCollectNewUseStatement(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $name, \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Name
    {
        // the same end is already imported → skip
        if ($this->classNameImportSkipper->shouldSkipNameForFullyQualifiedObjectType($name, $fullyQualifiedObjectType)) {
            return null;
        }
        if ($this->useNodesToAddCollector->isShortImported($name, $fullyQualifiedObjectType)) {
            if ($this->useNodesToAddCollector->isImportShortable($name, $fullyQualifiedObjectType)) {
                return $fullyQualifiedObjectType->getShortNameNode();
            }
            return null;
        }
        $this->addUseImport($name, $fullyQualifiedObjectType);
        // possibly aliased
        foreach ($this->aliasedUses as $aliasUse) {
            if ($fullyQualifiedObjectType->getClassName() === $aliasUse) {
                return null;
            }
        }
        return $fullyQualifiedObjectType->getShortNameNode();
    }
    /**
     * Skip:
     * - namespace name
     * - use import name
     */
    private function isNamespaceOrUseImportName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $name) : bool
    {
        $parentNode = $name->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_) {
            return \true;
        }
        return $parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse;
    }
    private function isFunctionOrConstantImportWithSingleName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $name) : bool
    {
        $parentNode = $name->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch && !$parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return \count((array) $name->parts) === 1;
    }
    private function isNonExistingClassLikeAndFunctionFullyQualifiedName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $name) : bool
    {
        if (!$name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified) {
            return \false;
        }
        // can be also in to be renamed classes
        $classOrFunctionName = $name->toString();
        $oldToNewClasses = $this->renamedClassesCollector->getOldToNewClasses();
        if (\in_array($classOrFunctionName, $oldToNewClasses, \true)) {
            return \false;
        }
        // skip-non existing class-likes and functions
        if (\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($classOrFunctionName)) {
            return \false;
        }
        return !\function_exists($classOrFunctionName);
    }
    private function addUseImport(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $name, \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : void
    {
        if ($this->useNodesToAddCollector->hasImport($name, $fullyQualifiedObjectType)) {
            return;
        }
        $parentNode = $name->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall) {
            $this->useNodesToAddCollector->addFunctionUseImport($name, $fullyQualifiedObjectType);
        } else {
            $this->useNodesToAddCollector->addUseImport($name, $fullyQualifiedObjectType);
        }
    }
}
