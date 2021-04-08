<?php

declare (strict_types=1);
namespace Rector\FileSystemRector\ValueObjectFactory;

use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Namespace_;
use Rector\Autodiscovery\Configuration\CategoryNamespaceProvider;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
use Rector\PSR4\FileRelocationResolver;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\Autodiscovery\Configuration\CategoryNamespaceProvider $categoryNamespaceProvider, \Rector\PSR4\FileRelocationResolver $fileRelocationResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->fileRelocationResolver = $fileRelocationResolver;
        $this->categoryNamespaceProvider = $categoryNamespaceProvider;
    }
    /**
     * @param Node[] $nodes
     */
    public function createWithDesiredGroup(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $oldFileInfo, array $nodes, string $desiredGroupName) : ?\Rector\FileSystemRector\ValueObject\MovedFileWithNodes
    {
        $currentNamespace = $this->betterNodeFinder->findFirstInstanceOf($nodes, \PhpParser\Node\Stmt\Namespace_::class);
        // file without namespace → skip
        if (!$currentNamespace instanceof \PhpParser\Node\Stmt\Namespace_) {
            return null;
        }
        if ($currentNamespace->name === null) {
            return null;
        }
        // is already in the right group
        $currentNamespaceName = (string) $currentNamespace->name;
        if (\RectorPrefix20210408\Nette\Utils\Strings::endsWith($currentNamespaceName, '\\' . $desiredGroupName)) {
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
        if (\RectorPrefix20210408\Nette\Utils\Strings::match($oldClassName, '#\\b' . $desiredGroupName . '\\b#')) {
            return null;
        }
        // 1. rename namespace
        $this->renameNamespace($nodes, $newNamespaceName);
        // 2. return changed nodes and new file destination
        $newFileDestination = $this->fileRelocationResolver->createNewFileDestination($oldFileInfo, $desiredGroupName, $this->categoryNamespaceProvider->provide());
        // 3. update fully qualifed name of the class like - will be used further
        $classLike = $this->betterNodeFinder->findFirstInstanceOf($nodes, \PhpParser\Node\Stmt\ClassLike::class);
        if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike) {
            return null;
        }
        // clone to prevent deep override
        $classLike = clone $classLike;
        $classLike->namespacedName = new \PhpParser\Node\Name\FullyQualified($newClassName);
        return new \Rector\FileSystemRector\ValueObject\MovedFileWithNodes($nodes, $newFileDestination, $oldFileInfo, $oldClassName, $newClassName);
    }
    private function createNewNamespaceName(string $desiredGroupName, \PhpParser\Node\Stmt\Namespace_ $currentNamespace) : string
    {
        return $this->fileRelocationResolver->resolveNewNamespaceName($currentNamespace, $desiredGroupName, $this->categoryNamespaceProvider->provide());
    }
    private function createNewClassName(\RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $newNamespaceName) : string
    {
        return $newNamespaceName . '\\' . $smartFileInfo->getBasenameWithoutSuffix();
    }
    /**
     * @param Node[] $nodes
     */
    private function renameNamespace(array $nodes, string $newNamespaceName) : void
    {
        foreach ($nodes as $node) {
            if (!$node instanceof \PhpParser\Node\Stmt\Namespace_) {
                continue;
            }
            // prevent namespace override
            $node = clone $node;
            $node->name = new \PhpParser\Node\Name($newNamespaceName);
            break;
        }
    }
}
