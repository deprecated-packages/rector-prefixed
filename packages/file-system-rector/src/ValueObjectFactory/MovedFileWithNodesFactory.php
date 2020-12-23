<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObjectFactory;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a2ac50786fa\Rector\Autodiscovery\Configuration\CategoryNamespaceProvider;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
use _PhpScoper0a2ac50786fa\Rector\PSR4\FileRelocationResolver;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a2ac50786fa\Rector\Autodiscovery\Configuration\CategoryNamespaceProvider $categoryNamespaceProvider, \_PhpScoper0a2ac50786fa\Rector\PSR4\FileRelocationResolver $fileRelocationResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->fileRelocationResolver = $fileRelocationResolver;
        $this->categoryNamespaceProvider = $categoryNamespaceProvider;
    }
    /**
     * @param Node[] $nodes
     */
    public function createWithDesiredGroup(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $oldFileInfo, array $nodes, string $desiredGroupName) : ?\_PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\MovedFileWithNodes
    {
        /** @var Namespace_|null $currentNamespace */
        $currentNamespace = $this->betterNodeFinder->findFirstInstanceOf($nodes, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_::class);
        // file without namespace → skip
        if ($currentNamespace === null || $currentNamespace->name === null) {
            return null;
        }
        // is already in the right group
        $currentNamespaceName = (string) $currentNamespace->name;
        if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::endsWith($currentNamespaceName, '\\' . $desiredGroupName)) {
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
        if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::match($oldClassName, '#\\b' . $desiredGroupName . '\\b#')) {
            return null;
        }
        // 1. rename namespace
        $this->renameNamespace($nodes, $newNamespaceName);
        // 2. return changed nodes and new file destination
        $newFileDestination = $this->fileRelocationResolver->createNewFileDestination($oldFileInfo, $desiredGroupName, $this->categoryNamespaceProvider->provide());
        // 3. update fully qualifed name of the class like - will be used further
        /** @var ClassLike|null $classLike */
        $classLike = $this->betterNodeFinder->findFirstInstanceOf($nodes, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike::class);
        if ($classLike === null) {
            return null;
        }
        // clone to prevent deep override
        $classLike = clone $classLike;
        $classLike->namespacedName = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified($newClassName);
        return new \_PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObject\MovedFileWithNodes($nodes, $newFileDestination, $oldFileInfo, $oldClassName, $newClassName);
    }
    private function createNewNamespaceName(string $desiredGroupName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_ $currentNamespace) : string
    {
        return $this->fileRelocationResolver->resolveNewNamespaceName($currentNamespace, $desiredGroupName, $this->categoryNamespaceProvider->provide());
    }
    private function createNewClassName(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $newNamespaceName) : string
    {
        return $newNamespaceName . '\\' . $smartFileInfo->getBasenameWithoutSuffix();
    }
    /**
     * @param Node[] $nodes
     */
    private function renameNamespace(array $nodes, string $newNamespaceName) : void
    {
        foreach ($nodes as $node) {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_) {
                continue;
            }
            // prevent namespace override
            $node = clone $node;
            $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($newNamespaceName);
            break;
        }
    }
}
