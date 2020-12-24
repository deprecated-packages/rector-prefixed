<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\FileSystemRector\ValueObjectFactory;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\Rector\Autodiscovery\Configuration\CategoryNamespaceProvider;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
use _PhpScopere8e811afab72\Rector\PSR4\FileRelocationResolver;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class MovedFileWithNodesFactory
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var FileRelocationResolver
     */
    private $fileRelocationResolver;
    /**
     * @var CategoryNamespaceProvider
     */
    private $categoryNamespaceProvider;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\Autodiscovery\Configuration\CategoryNamespaceProvider $categoryNamespaceProvider, \_PhpScopere8e811afab72\Rector\PSR4\FileRelocationResolver $fileRelocationResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->fileRelocationResolver = $fileRelocationResolver;
        $this->categoryNamespaceProvider = $categoryNamespaceProvider;
    }
    /**
     * @param Node[] $nodes
     */
    public function createWithDesiredGroup(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $oldFileInfo, array $nodes, string $desiredGroupName) : ?\_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\MovedFileWithNodes
    {
        /** @var Namespace_|null $currentNamespace */
        $currentNamespace = $this->betterNodeFinder->findFirstInstanceOf($nodes, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_::class);
        // file without namespace → skip
        if ($currentNamespace === null || $currentNamespace->name === null) {
            return null;
        }
        // is already in the right group
        $currentNamespaceName = (string) $currentNamespace->name;
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($currentNamespaceName, '\\' . $desiredGroupName)) {
            return null;
        }
        $oldClassName = $currentNamespaceName . '\\' . $oldFileInfo->getBasenameWithoutSuffix();
        // change namespace to new one
        $newNamespaceName = $this->createNewNamespaceName($desiredGroupName, $currentNamespace);
        $newClassName = $this->createNewClassName($oldFileInfo, $newNamespaceName);
        // classes are identical, no rename
        if ($oldClassName === $newClassName) {
            return null;
        }
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::match($oldClassName, '#\\b' . $desiredGroupName . '\\b#')) {
            return null;
        }
        // 1. rename namespace
        $this->renameNamespace($nodes, $newNamespaceName);
        // 2. return changed nodes and new file destination
        $newFileDestination = $this->fileRelocationResolver->createNewFileDestination($oldFileInfo, $desiredGroupName, $this->categoryNamespaceProvider->provide());
        // 3. update fully qualifed name of the class like - will be used further
        /** @var ClassLike|null $classLike */
        $classLike = $this->betterNodeFinder->findFirstInstanceOf($nodes, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike::class);
        if ($classLike === null) {
            return null;
        }
        // clone to prevent deep override
        $classLike = clone $classLike;
        $classLike->namespacedName = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($newClassName);
        return new \_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\MovedFileWithNodes($nodes, $newFileDestination, $oldFileInfo, $oldClassName, $newClassName);
    }
    private function createNewNamespaceName(string $desiredGroupName, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ $currentNamespace) : string
    {
        return $this->fileRelocationResolver->resolveNewNamespaceName($currentNamespace, $desiredGroupName, $this->categoryNamespaceProvider->provide());
    }
    private function createNewClassName(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $newNamespaceName) : string
    {
        return $newNamespaceName . '\\' . $smartFileInfo->getBasenameWithoutSuffix();
    }
    /**
     * @param Node[] $nodes
     */
    private function renameNamespace(array $nodes, string $newNamespaceName) : void
    {
        foreach ($nodes as $node) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_) {
                continue;
            }
            // prevent namespace override
            $node = clone $node;
            $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Name($newNamespaceName);
            break;
        }
    }
}
