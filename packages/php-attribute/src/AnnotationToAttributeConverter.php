<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PhpAttribute;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Attribute;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrowFunction;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
use _PhpScoper0a2ac50786fa\Rector\PhpAttribute\Printer\PhpAttributteGroupFactory;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
final class AnnotationToAttributeConverter
{
    /**
     * @var PhpAttributteGroupFactory
     */
    private $phpAttributteGroupFactory;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\PhpAttribute\Printer\PhpAttributteGroupFactory $phpAttributteGroupFactory)
    {
        $this->phpAttributteGroupFactory = $phpAttributteGroupFactory;
    }
    /**
     * @param Class_|Property|ClassMethod|Function_|Closure|ArrowFunction $node
     */
    public function convertNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $hasNewAttrGroups = \false;
        // 0. has 0 nodes, nothing to change
        /** @var PhpAttributableTagNodeInterface[] $phpAttributableTagNodes */
        $phpAttributableTagNodes = $phpDocInfo->findAllByType(\_PhpScoper0a2ac50786fa\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface::class);
        if ($phpAttributableTagNodes === []) {
            return null;
        }
        // 1. keep only those, whom's attribute class exists
        $phpAttributableTagNodes = $this->filterOnlyExistingAttributes($phpAttributableTagNodes);
        if ($phpAttributableTagNodes !== []) {
            $hasNewAttrGroups = \true;
        }
        // 2. remove tags
        foreach ($phpAttributableTagNodes as $phpAttributableTagNode) {
            /** @var PhpDocTagValueNode $phpAttributableTagNode */
            $phpDocInfo->removeTagValueNodeFromNode($phpAttributableTagNode);
        }
        // 3. convert annotations to attributes
        $newAttrGroups = $this->phpAttributteGroupFactory->create($phpAttributableTagNodes);
        $node->attrGroups = \array_merge($node->attrGroups, $newAttrGroups);
        if ($hasNewAttrGroups) {
            return $node;
        }
        return null;
    }
    /**
     * @param PhpAttributableTagNodeInterface[] $phpAttributableTagNodes
     * @return PhpAttributableTagNodeInterface[]
     */
    private function filterOnlyExistingAttributes(array $phpAttributableTagNodes) : array
    {
        if (\_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            return $phpAttributableTagNodes;
        }
        return \array_filter($phpAttributableTagNodes, function (\_PhpScoper0a2ac50786fa\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface $phpAttributableTagNode) : bool {
            return \class_exists($phpAttributableTagNode->getAttributeClassName());
        });
    }
}
