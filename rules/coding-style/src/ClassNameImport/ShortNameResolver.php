<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\ClassNameImport;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->currentFileInfoProvider = $currentFileInfoProvider;
    }
    /**
     * @return string[]
     */
    public function resolveForNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
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
    public function resolveShortClassLikeNamesForNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        $namespace = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE);
        if ($namespace === null) {
            // only handle namespace nodes
            return [];
        }
        $shortClassLikeNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($namespace, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$shortClassLikeNames) {
            // ...
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
                return null;
            }
            if ($node->name === null) {
                return null;
            }
            /** @var string $classShortName */
            $classShortName = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_SHORT_NAME);
            $shortClassLikeNames[] = $classShortName;
        });
        return \array_unique($shortClassLikeNames);
    }
    private function getNodeRealPath(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        /** @var SmartFileInfo|null $fileInfo */
        $fileInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
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
        $this->callableNodeTraverser->traverseNodesWithCallable($stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$shortNames) : void {
            // class name is used!
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike && $node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier) {
                $shortNames[$node->name->toString()] = $node->name->toString();
                return;
            }
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
                return;
            }
            $originalName = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME);
            if (!$originalName instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
                return;
            }
            // already short
            if (\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($originalName->toString(), '\\')) {
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
        $this->callableNodeTraverser->traverseNodesWithCallable($stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$shortNames) {
            /** @var PhpDocInfo|null $phpDocInfo */
            $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
    private function resolveShortTagNameFromPhpDocChildNode(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode $phpDocChildNode) : ?string
    {
        if (!$phpDocChildNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
            return null;
        }
        $tagName = \ltrim($phpDocChildNode->name, '@');
        // is annotation class - big letter?
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::match($tagName, self::BIG_LETTER_START_REGEX)) {
            return $tagName;
        }
        if (!$this->isValueNodeWithType($phpDocChildNode->value)) {
            return null;
        }
        $typeNode = $phpDocChildNode->value->type;
        if (!$typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return null;
        }
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($typeNode->name, '\\')) {
            return null;
        }
        return $typeNode->name;
    }
    private function isValueNodeWithType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : bool
    {
        return $phpDocTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode || $phpDocTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode || $phpDocTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode || $phpDocTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode || $phpDocTagValueNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
    }
}
