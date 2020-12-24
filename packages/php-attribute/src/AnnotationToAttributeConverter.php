<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PhpAttribute;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Attribute;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrowFunction;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
use _PhpScoperb75b35f52b74\Rector\PhpAttribute\Printer\PhpAttributteGroupFactory;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
final class AnnotationToAttributeConverter
{
    /**
     * @var PhpAttributteGroupFactory
     */
    private $phpAttributteGroupFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\PhpAttribute\Printer\PhpAttributteGroupFactory $phpAttributteGroupFactory)
    {
        $this->phpAttributteGroupFactory = $phpAttributteGroupFactory;
    }
    /**
     * @param Class_|Property|ClassMethod|Function_|Closure|ArrowFunction $node
     */
    public function convertNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $hasNewAttrGroups = \false;
        // 0. has 0 nodes, nothing to change
        /** @var PhpAttributableTagNodeInterface[] $phpAttributableTagNodes */
        $phpAttributableTagNodes = $phpDocInfo->findAllByType(\_PhpScoperb75b35f52b74\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface::class);
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
        if (\_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            return $phpAttributableTagNodes;
        }
        return \array_filter($phpAttributableTagNodes, function (\_PhpScoperb75b35f52b74\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface $phpAttributableTagNode) : bool {
            return \class_exists($phpAttributableTagNode->getAttributeClassName());
        });
    }
}
