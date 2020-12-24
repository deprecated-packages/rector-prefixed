<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Node;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\AliasUsesResolver;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipper;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Option;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Rector\PostRector\Collector\UseNodesToAddCollector;
use _PhpScoperb75b35f52b74\Rector\PSR4\Collector\RenamedClassesCollector;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\AliasUsesResolver $aliasUsesResolver, \_PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipper $classNameImportSkipper, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScoperb75b35f52b74\Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector, \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoperb75b35f52b74\Rector\PostRector\Collector\UseNodesToAddCollector $useNodesToAddCollector)
    {
        $this->staticTypeMapper = $staticTypeMapper;
        $this->aliasUsesResolver = $aliasUsesResolver;
        $this->classNameImportSkipper = $classNameImportSkipper;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->parameterProvider = $parameterProvider;
        $this->useNodesToAddCollector = $useNodesToAddCollector;
        $this->renamedClassesCollector = $renamedClassesCollector;
    }
    public function importName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $name) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Name
    {
        if ($this->shouldSkipName($name)) {
            return null;
        }
        if ($this->classNameImportSkipper->isShortNameInUseStatement($name)) {
            return null;
        }
        $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($name);
        if (!$staticType instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType) {
            return null;
        }
        $this->aliasedUses = $this->aliasUsesResolver->resolveForNode($name);
        return $this->importNameAndCollectNewUseStatement($name, $staticType);
    }
    private function shouldSkipName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $name) : bool
    {
        $virtualNode = $name->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::VIRTUAL_NODE);
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
        $importShortClasses = $this->parameterProvider->provideParameter(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::IMPORT_SHORT_CLASSES);
        if (!$importShortClasses) {
            $name = $this->nodeNameResolver->getName($name);
            if ($name !== null && \substr_count($name, '\\') === 0) {
                return \true;
            }
        }
        return \false;
    }
    private function importNameAndCollectNewUseStatement(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $name, \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Name
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
    private function isNamespaceOrUseImportName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $name) : bool
    {
        $parentNode = $name->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_) {
            return \true;
        }
        return $parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse;
    }
    private function isFunctionOrConstantImportWithSingleName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $name) : bool
    {
        $parentNode = $name->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch && !$parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return \count((array) $name->parts) === 1;
    }
    private function isNonExistingClassLikeAndFunctionFullyQualifiedName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $name) : bool
    {
        if (!$name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified) {
            return \false;
        }
        // can be also in to be renamed classes
        $classOrFunctionName = $name->toString();
        $oldToNewClasses = $this->renamedClassesCollector->getOldToNewClasses();
        if (\in_array($classOrFunctionName, $oldToNewClasses, \true)) {
            return \false;
        }
        // skip-non existing class-likes and functions
        if (\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($classOrFunctionName)) {
            return \false;
        }
        return !\function_exists($classOrFunctionName);
    }
    private function addUseImport(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $name, \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : void
    {
        if ($this->useNodesToAddCollector->hasImport($name, $fullyQualifiedObjectType)) {
            return;
        }
        $parentNode = $name->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            $this->useNodesToAddCollector->addFunctionUseImport($name, $fullyQualifiedObjectType);
        } else {
            $this->useNodesToAddCollector->addUseImport($name, $fullyQualifiedObjectType);
        }
    }
}
