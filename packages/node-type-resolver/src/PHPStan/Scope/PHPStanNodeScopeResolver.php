<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Scope;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Interface_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Trait_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser;
use _PhpScoper2a4e7ab1ecbc\PHPStan\AnalysedCodeException;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\MutatingScope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NodeScopeResolver;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Node\UnreachableStatementNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper2a4e7ab1ecbc\Rector\Caching\Detector\ChangedFilesDetector;
use _PhpScoper2a4e7ab1ecbc\Rector\Caching\FileSystem\DependencyResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Configuration;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Scope\NodeVisitor\RemoveDeepChainMethodCallNodeVisitor;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Caching\Detector\ChangedFilesDetector $changedFilesDetector, \_PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Configuration $configuration, \_PhpScoper2a4e7ab1ecbc\Rector\Caching\FileSystem\DependencyResolver $dependencyResolver, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Scope\NodeVisitor\RemoveDeepChainMethodCallNodeVisitor $removeDeepChainMethodCallNodeVisitor, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Scope\ScopeFactory $scopeFactory, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Collector\TraitNodeScopeCollector $traitNodeScopeCollector)
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
    public function processNodes(array $nodes, \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : array
    {
        $this->removeDeepChainMethodCallNodes($nodes);
        $scope = $this->scopeFactory->createFromFile($smartFileInfo);
        $this->dependentFiles = [];
        // skip chain method calls, performance issue: https://github.com/phpstan/phpstan/issues/254
        $nodeCallback = function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : void {
            // the class reflection is resolved AFTER entering to class node
            // so we need to get it from the first after this one
            if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ || $node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Interface_) {
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
            if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Node\UnreachableStatementNode) {
                $originalNode = $node->getOriginalStatement();
                $originalNode->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::IS_UNREACHABLE, \true);
                $originalNode->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE, $scope);
            } else {
                $node->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE, $scope);
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
        $nodeTraverser = new \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->removeDeepChainMethodCallNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
    /**
     * @param Class_|Interface_ $classLike
     */
    private function resolveClassOrInterfaceScope(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike $classLike, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\MutatingScope
    {
        $className = $this->resolveClassName($classLike);
        // is anonymous class? - not possible to enter it since PHPStan 0.12.33, see https://github.com/phpstan/phpstan-src/commit/e87fb0ec26f9c8552bbeef26a868b1e5d8185e91
        if ($classLike instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ && \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::match($className, self::ANONYMOUS_CLASS_START_REGEX)) {
            $classReflection = $this->reflectionProvider->getAnonymousClassReflection($classLike, $scope);
        } else {
            $classReflection = $this->reflectionProvider->getClass($className);
        }
        /** @var MutatingScope $scope */
        return $scope->enterClass($classReflection);
    }
    private function resolveDependentFiles(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : void
    {
        if (!$this->configuration->isCacheEnabled()) {
            return;
        }
        try {
            $dependentFiles = $this->dependencyResolver->resolveDependencies($node, $scope);
            foreach ($dependentFiles as $dependentFile) {
                $this->dependentFiles[] = $dependentFile;
            }
        } catch (\_PhpScoper2a4e7ab1ecbc\PHPStan\AnalysedCodeException $analysedCodeException) {
            // @ignoreException
        }
    }
    /**
     * @param string[] $dependentFiles
     */
    private function reportCacheDebugAndSaveDependentFiles(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, array $dependentFiles) : void
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
    private function resolveClassName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike $classLike) : string
    {
        if (\property_exists($classLike, 'namespacedName')) {
            return (string) $classLike->namespacedName;
        }
        if ($classLike->name === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $classLike->name->toString();
    }
    /**
     * @param string[] $dependentFiles
     */
    private function reportCacheDebug(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, array $dependentFiles) : void
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
