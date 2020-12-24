<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PSR4\Rector\Namespace_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Declare_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\MovedFileWithNodes;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\PSR4\FileInfoAnalyzer\FileInfoDeletionAnalyzer;
use _PhpScoper0a6b37af0871\Rector\PSR4\NodeManipulator\NamespaceManipulator;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\PSR4\Tests\Rector\Namespace_\MultipleClassFileToPsr4ClassesRector\MultipleClassFileToPsr4ClassesRectorTest
 */
final class MultipleClassFileToPsr4ClassesRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var NamespaceManipulator
     */
    private $namespaceManipulator;
    /**
     * @var FileInfoDeletionAnalyzer
     */
    private $fileInfoDeletionAnalyzer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\PSR4\NodeManipulator\NamespaceManipulator $namespaceManipulator, \_PhpScoper0a6b37af0871\Rector\PSR4\FileInfoAnalyzer\FileInfoDeletionAnalyzer $fileInfoDeletionAnalyzer)
    {
        $this->namespaceManipulator = $namespaceManipulator;
        $this->fileInfoDeletionAnalyzer = $fileInfoDeletionAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change multiple classes in one file to standalone PSR-4 classes.', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
namespace App\Exceptions;

use Exception;

final class FirstException extends Exception
{
}

final class SecondException extends Exception
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
// new file: "app/Exceptions/FirstException.php"
namespace App\Exceptions;

use Exception;

final class FirstException extends Exception
{
}

// new file: "app/Exceptions/SecondException.php"
namespace App\Exceptions;

use Exception;

final class SecondException extends Exception
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_::class, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace::class];
    }
    /**
     * @param Namespace_|FileWithoutNamespace $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->hasAtLeastTwoClassLikes($node)) {
            return null;
        }
        $nodeToReturn = null;
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_) {
            $nodeToReturn = $this->refactorNamespace($node);
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace) {
            $nodeToReturn = $this->refactorFileWithoutNamespace($node);
        }
        // 1. remove this node
        if ($nodeToReturn !== null) {
            return $nodeToReturn;
        }
        /** @var SmartFileInfo $smartFileInfo */
        $smartFileInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        // 2. nothing to return - remove the file
        $this->removeFile($smartFileInfo);
        return null;
    }
    private function hasAtLeastTwoClassLikes(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        $classes = $this->betterNodeFinder->findClassLikes($node);
        return \count($classes) > 1;
    }
    private function refactorNamespace(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_ $namespace) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_
    {
        /** @var ClassLike[] $classLikes */
        $classLikes = $this->betterNodeFinder->findClassLikes($namespace->stmts);
        $emptyNamespace = $this->namespaceManipulator->removeClassLikes($namespace);
        $nodeToReturn = null;
        foreach ($classLikes as $classLike) {
            $newNamespace = clone $emptyNamespace;
            $newNamespace->stmts[] = $classLike;
            // 1. is the class that will be kept in original file?
            if ($this->fileInfoDeletionAnalyzer->isClassLikeAndFileInfoMatch($classLike)) {
                $nodeToReturn = $newNamespace;
                continue;
            }
            // 2. new file
            $this->printNewNodes($classLike, $newNamespace);
        }
        return $nodeToReturn;
    }
    private function refactorFileWithoutNamespace(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace $fileWithoutNamespace) : ?\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace
    {
        /** @var ClassLike[] $classLikes */
        $classLikes = $this->betterNodeFinder->findClassLikes($fileWithoutNamespace->stmts);
        $nodeToReturn = null;
        foreach ($classLikes as $classLike) {
            // 1. is the class that will be kept in original file?
            if ($this->fileInfoDeletionAnalyzer->isClassLikeAndFileInfoMatch($classLike)) {
                $nodeToReturn = $fileWithoutNamespace;
                continue;
            }
            // 2. is new file
            $this->printNewNodes($classLike, $fileWithoutNamespace);
        }
        return $nodeToReturn;
    }
    /**
     * @param Namespace_|FileWithoutNamespace $mainNode
     */
    private function printNewNodes(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike, \_PhpScoper0a6b37af0871\PhpParser\Node $mainNode) : void
    {
        /** @var SmartFileInfo $smartFileInfo */
        $smartFileInfo = $mainNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        /** @var Declare_[] $declares */
        $declares = (array) $mainNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::DECLARES);
        if ($mainNode instanceof \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace) {
            $nodesToPrint = \array_merge($declares, [$classLike]);
        } else {
            $nodesToPrint = \array_merge($declares, [$mainNode]);
        }
        $fileDestination = $this->createClassLikeFileDestination($classLike, $smartFileInfo);
        $movedFileWithNodes = new \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\MovedFileWithNodes($nodesToPrint, $fileDestination, $smartFileInfo);
        $this->addMovedFile($movedFileWithNodes);
    }
    private function createClassLikeFileDestination(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        $currentDirectory = \dirname($smartFileInfo->getRealPath());
        return $currentDirectory . \DIRECTORY_SEPARATOR . $classLike->name . '.php';
    }
}
