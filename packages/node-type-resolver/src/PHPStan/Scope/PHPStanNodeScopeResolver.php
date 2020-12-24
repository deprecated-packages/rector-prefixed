<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Scope;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PHPStan\AnalysedCodeException;
use _PhpScopere8e811afab72\PHPStan\Analyser\MutatingScope;
use _PhpScopere8e811afab72\PHPStan\Analyser\NodeScopeResolver;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\UnreachableStatementNode;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\Rector\Caching\Detector\ChangedFilesDetector;
use _PhpScopere8e811afab72\Rector\Caching\FileSystem\DependencyResolver;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Configuration;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Scope\NodeVisitor\RemoveDeepChainMethodCallNodeVisitor;
use _PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @inspired by https://github.com/silverstripe/silverstripe-upgrader/blob/532182b23e854d02e0b27e68ebc394f436de0682/src/UpgradeRule/PHP/Visitor/PHPStanScopeVisitor.php
 * - https://github.com/silverstripe/silverstripe-upgrader/pull/57/commits/e5c7cfa166ad940d9d4ff69537d9f7608e992359#diff-5e0807bb3dc03d6a8d8b6ad049abd774
 */
final class PHPStanNodeScopeResolver
{
    /**
     * @var string
     * @see https://regex101.com/r/aXsCkK/1
     */
    private const ANONYMOUS_CLASS_START_REGEX = '#^AnonymousClass(\\w+)#';
    /**
     * @var string[]
     */
    private $dependentFiles = [];
    /**
     * @var NodeScopeResolver
     */
    private $nodeScopeResolver;
    /**
     * @var ScopeFactory
     */
    private $scopeFactory;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var RemoveDeepChainMethodCallNodeVisitor
     */
    private $removeDeepChainMethodCallNodeVisitor;
    /**
     * @var TraitNodeScopeCollector
     */
    private $traitNodeScopeCollector;
    /**
     * @var DependencyResolver
     */
    private $dependencyResolver;
    /**
     * @var ChangedFilesDetector
     */
    private $changedFilesDetector;
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    public function __construct(\_PhpScopere8e811afab72\Rector\Caching\Detector\ChangedFilesDetector $changedFilesDetector, \_PhpScopere8e811afab72\Rector\Core\Configuration\Configuration $configuration, \_PhpScopere8e811afab72\Rector\Caching\FileSystem\DependencyResolver $dependencyResolver, \_PhpScopere8e811afab72\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver, \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Scope\NodeVisitor\RemoveDeepChainMethodCallNodeVisitor $removeDeepChainMethodCallNodeVisitor, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Scope\ScopeFactory $scopeFactory, \_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector $traitNodeScopeCollector)
    {
        $this->scopeFactory = $scopeFactory;
        $this->nodeScopeResolver = $nodeScopeResolver;
        $this->reflectionProvider = $reflectionProvider;
        $this->removeDeepChainMethodCallNodeVisitor = $removeDeepChainMethodCallNodeVisitor;
        $this->traitNodeScopeCollector = $traitNodeScopeCollector;
        $this->dependencyResolver = $dependencyResolver;
        $this->changedFilesDetector = $changedFilesDetector;
        $this->configuration = $configuration;
        $this->symfonyStyle = $symfonyStyle;
    }
    /**
     * @param Node[] $nodes
     * @return Node[]
     */
    public function processNodes(array $nodes, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : array
    {
        $this->removeDeepChainMethodCallNodes($nodes);
        $scope = $this->scopeFactory->createFromFile($smartFileInfo);
        $this->dependentFiles = [];
        // skip chain method calls, performance issue: https://github.com/phpstan/phpstan/issues/254
        $nodeCallback = function (\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : void {
            // the class reflection is resolved AFTER entering to class node
            // so we need to get it from the first after this one
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_) {
                /** @var Scope $scope */
                $scope = $this->resolveClassOrInterfaceScope($node, $scope);
            }
            // traversing trait inside class that is using it scope (from referenced) - the trait traversed by Rector is different (directly from parsed file)
            if ($scope->isInTrait()) {
                /** @var ClassReflection $classReflection */
                $classReflection = $scope->getTraitReflection();
                $traitName = $classReflection->getName();
                $this->traitNodeScopeCollector->addForTraitAndNode($traitName, $node, $scope);
                return;
            }
            // special case for unreachable nodes
            if ($node instanceof \_PhpScopere8e811afab72\PHPStan\Node\UnreachableStatementNode) {
                $originalNode = $node->getOriginalStatement();
                $originalNode->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE, \true);
                $originalNode->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE, $scope);
            } else {
                $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE, $scope);
            }
        };
        foreach ($nodes as $node) {
            $this->resolveDependentFiles($node, $scope);
        }
        /** @var MutatingScope $scope */
        $this->nodeScopeResolver->processNodes($nodes, $scope, $nodeCallback);
        $this->reportCacheDebugAndSaveDependentFiles($smartFileInfo, $this->dependentFiles);
        return $nodes;
    }
    /**
     * @param Node[] $nodes
     */
    private function removeDeepChainMethodCallNodes(array $nodes) : void
    {
        $nodeTraverser = new \_PhpScopere8e811afab72\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->removeDeepChainMethodCallNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
    /**
     * @param Class_|Interface_ $classLike
     */
    private function resolveClassOrInterfaceScope(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Analyser\MutatingScope
    {
        $className = $this->resolveClassName($classLike);
        // is anonymous class? - not possible to enter it since PHPStan 0.12.33, see https://github.com/phpstan/phpstan-src/commit/e87fb0ec26f9c8552bbeef26a868b1e5d8185e91
        if ($classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ && \_PhpScopere8e811afab72\Nette\Utils\Strings::match($className, self::ANONYMOUS_CLASS_START_REGEX)) {
            $classReflection = $this->reflectionProvider->getAnonymousClassReflection($classLike, $scope);
        } else {
            $classReflection = $this->reflectionProvider->getClass($className);
        }
        /** @var MutatingScope $scope */
        return $scope->enterClass($classReflection);
    }
    private function resolveDependentFiles(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : void
    {
        if (!$this->configuration->isCacheEnabled()) {
            return;
        }
        try {
            $dependentFiles = $this->dependencyResolver->resolveDependencies($node, $scope);
            foreach ($dependentFiles as $dependentFile) {
                $this->dependentFiles[] = $dependentFile;
            }
        } catch (\_PhpScopere8e811afab72\PHPStan\AnalysedCodeException $analysedCodeException) {
            // @ignoreException
        }
    }
    /**
     * @param string[] $dependentFiles
     */
    private function reportCacheDebugAndSaveDependentFiles(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, array $dependentFiles) : void
    {
        if (!$this->configuration->isCacheEnabled()) {
            return;
        }
        $this->reportCacheDebug($smartFileInfo, $dependentFiles);
        // save for cache
        $this->changedFilesDetector->addFileWithDependencies($smartFileInfo, $dependentFiles);
    }
    /**
     * @param Class_|Interface_|Trait_ $classLike
     */
    private function resolveClassName(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : string
    {
        if (\property_exists($classLike, 'namespacedName')) {
            return (string) $classLike->namespacedName;
        }
        if ($classLike->name === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $classLike->name->toString();
    }
    /**
     * @param string[] $dependentFiles
     */
    private function reportCacheDebug(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, array $dependentFiles) : void
    {
        if (!$this->configuration->isCacheDebug()) {
            return;
        }
        $message = \sprintf('[debug] %d dependencies for "%s" file', \count($dependentFiles), $smartFileInfo->getRealPath());
        $this->symfonyStyle->note($message);
        if ($dependentFiles !== []) {
            $this->symfonyStyle->listing($dependentFiles);
        }
    }
}
