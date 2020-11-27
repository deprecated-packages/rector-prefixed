<?php

declare (strict_types=1);
namespace Rector\PhpAttribute;

use PhpParser\Node;
use PhpParser\Node\Attribute;
use PhpParser\Node\AttributeGroup;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
use Rector\PhpAttribute\Printer\PhpAttributteGroupFactory;
final class AnnotationToAttributeConverter
{
    /**
     * @var PhpAttributteGroupFactory
     */
    private $phpAttributteGroupFactory;
    public function __construct(\Rector\PhpAttribute\Printer\PhpAttributteGroupFactory $phpAttributteGroupFactory)
    {
        $this->phpAttributteGroupFactory = $phpAttributteGroupFactory;
    }
    /**
     * @param Class_|Property|ClassMethod|Function_|Closure|ArrowFunction $node
     */
    public function convertNode(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        // special cases without tag value node
        $hasNewAttrGroups = \false;
        if ($phpDocInfo->hasByName('required')) {
            $phpDocInfo->removeByName('required');
            $node->attrGroups[] = new \PhpParser\Node\AttributeGroup([new \PhpParser\Node\Attribute(new \PhpParser\Node\Name\FullyQualified('_PhpScoperbd5d0c5f7638\\Symfony\\Contracts\\Service\\Attribute\\Required'))]);
            $hasNewAttrGroups = \true;
        }
        // 0. has 0 nodes, nothing to change
        /** @var PhpAttributableTagNodeInterface[]&PhpDocTagValueNode[] $phpAttributableTagNodes */
        $phpAttributableTagNodes = $phpDocInfo->findAllByType(\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface::class);
        if ($phpAttributableTagNodes === [] && !$hasNewAttrGroups) {
            return null;
        }
        if ($phpAttributableTagNodes !== []) {
            $hasNewAttrGroups = \true;
        }
        // 1. remove tags
        foreach ($phpAttributableTagNodes as $phpAttributableTagNode) {
            $phpDocInfo->removeTagValueNodeFromNode($phpAttributableTagNode);
        }
        // 2. convert annotations to attributes
        $newAttrGroups = $this->phpAttributteGroupFactory->create($phpAttributableTagNodes);
        $node->attrGroups = \array_merge($node->attrGroups, $newAttrGroups);
        if ($hasNewAttrGroups) {
            return $node;
        }
        return null;
    }
}
