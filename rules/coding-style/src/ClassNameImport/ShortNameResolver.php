<?php

declare (strict_types=1);
namespace Rector\CodingStyle\ClassNameImport;

use RectorPrefix20210105\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\ClassLike;
use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20210105\Symplify\SmartFileSystem\SmartFileInfo;
final class ShortNameResolver
{
    /**
     * @var string
     * @see https://regex101.com/r/KphLd2/1
     */
    private const BIG_LETTER_START_REGEX = '#^[A-Z]#';
    /**
     * @var string[][]
     */
    private $shortNamesByFilePath = [];
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var CurrentFileInfoProvider
     */
    private $currentFileInfoProvider;
    public function __construct(\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->currentFileInfoProvider = $currentFileInfoProvider;
    }
    /**
     * @return string[]
     */
    public function resolveForNode(\PhpParser\Node $node) : array
    {
        $realPath = $this->getNodeRealPath($node);
        if (isset($this->shortNamesByFilePath[$realPath])) {
            return $this->shortNamesByFilePath[$realPath];
        }
        $currentStmts = $this->currentFileInfoProvider->getCurrentStmts();
        $shortNames = $this->resolveForStmts($currentStmts);
        $this->shortNamesByFilePath[$realPath] = $shortNames;
        return $shortNames;
    }
    /**
     * Collects all "class <SomeClass>", "trait <SomeTrait>" and "interface <SomeInterface>"
     * @return string[]
     */
    public function resolveShortClassLikeNamesForNode(\PhpParser\Node $node) : array
    {
        $namespace = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE);
        if ($namespace === null) {
            // only handle namespace nodes
            return [];
        }
        $shortClassLikeNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($namespace, function (\PhpParser\Node $node) use(&$shortClassLikeNames) {
            // ...
            if (!$node instanceof \PhpParser\Node\Stmt\ClassLike) {
                return null;
            }
            if ($node->name === null) {
                return null;
            }
            /** @var string $classShortName */
            $classShortName = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_SHORT_NAME);
            $shortClassLikeNames[] = $classShortName;
        });
        return \array_unique($shortClassLikeNames);
    }
    private function getNodeRealPath(\PhpParser\Node $node) : ?string
    {
        /** @var SmartFileInfo|null $fileInfo */
        $fileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo !== null) {
            return $fileInfo->getRealPath();
        }
        $smartFileInfo = $this->currentFileInfoProvider->getSmartFileInfo();
        if ($smartFileInfo !== null) {
            return $smartFileInfo->getRealPath();
        }
        return null;
    }
    /**
     * @param Node[] $stmts
     * @return string[]
     */
    private function resolveForStmts(array $stmts) : array
    {
        $shortNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($stmts, function (\PhpParser\Node $node) use(&$shortNames) : void {
            // class name is used!
            if ($node instanceof \PhpParser\Node\Stmt\ClassLike && $node->name instanceof \PhpParser\Node\Identifier) {
                $shortNames[$node->name->toString()] = $node->name->toString();
                return;
            }
            if (!$node instanceof \PhpParser\Node\Name) {
                return;
            }
            $originalName = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME);
            if (!$originalName instanceof \PhpParser\Node\Name) {
                return;
            }
            // already short
            if (\RectorPrefix20210105\Nette\Utils\Strings::contains($originalName->toString(), '\\')) {
                return;
            }
            $shortNames[$originalName->toString()] = $node->toString();
        });
        $docBlockShortNames = $this->resolveFromDocBlocks($stmts);
        return \array_merge($shortNames, $docBlockShortNames);
    }
    /**
     * @param Node[] $stmts
     * @return string[]
     */
    private function resolveFromDocBlocks(array $stmts) : array
    {
        $shortNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($stmts, function (\PhpParser\Node $node) use(&$shortNames) {
            /** @var PhpDocInfo|null $phpDocInfo */
            $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($phpDocInfo === null) {
                return null;
            }
            foreach ($phpDocInfo->getPhpDocNode()->children as $phpDocChildNode) {
                $shortTagName = $this->resolveShortTagNameFromPhpDocChildNode($phpDocChildNode);
                if ($shortTagName === null) {
                    continue;
                }
                $shortNames[$shortTagName] = $shortTagName;
            }
        });
        return $shortNames;
    }
    private function resolveShortTagNameFromPhpDocChildNode(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode $phpDocChildNode) : ?string
    {
        if (!$phpDocChildNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
            return null;
        }
        $tagName = \ltrim($phpDocChildNode->name, '@');
        // is annotation class - big letter?
        if (\RectorPrefix20210105\Nette\Utils\Strings::match($tagName, self::BIG_LETTER_START_REGEX)) {
            return $tagName;
        }
        if (!$this->isValueNodeWithType($phpDocChildNode->value)) {
            return null;
        }
        $typeNode = $phpDocChildNode->value->type;
        if (!$typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return null;
        }
        if (\RectorPrefix20210105\Nette\Utils\Strings::contains($typeNode->name, '\\')) {
            return null;
        }
        return $typeNode->name;
    }
    private function isValueNodeWithType(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : bool
    {
        return $phpDocTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode || $phpDocTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode || $phpDocTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode || $phpDocTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode || $phpDocTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
    }
}
