<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpDoc;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class PhpDocClassRenamer
{
    /**
     * Covers annotations like @ORM, @Serializer, @Assert etc
     * See https://github.com/rectorphp/rector/issues/1872
     *
     * @param string[] $oldToNewClasses
     */
    public function changeTypeInAnnotationTypes(\_PhpScopere8e811afab72\PhpParser\Node $node, array $oldToNewClasses) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $this->processAssertChoiceTagValueNode($oldToNewClasses, $phpDocInfo);
        $this->processDoctrineRelationTagValueNode($oldToNewClasses, $phpDocInfo);
        $this->processSerializerTypeTagValueNode($oldToNewClasses, $phpDocInfo);
    }
    /**
     * @param string[] $oldToNewClasses
     */
    private function processAssertChoiceTagValueNode(array $oldToNewClasses, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $assertChoiceTagValueNode = $phpDocInfo->getByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode::class);
        if (!$assertChoiceTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode) {
            return;
        }
        foreach ($oldToNewClasses as $oldClass => $newClass) {
            if (!$assertChoiceTagValueNode->isCallbackClass($oldClass)) {
                continue;
            }
            $assertChoiceTagValueNode->changeCallbackClass($newClass);
            break;
        }
    }
    /**
     * @param string[] $oldToNewClasses
     */
    private function processDoctrineRelationTagValueNode(array $oldToNewClasses, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $doctrineRelationTagValueNode = $phpDocInfo->getByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
        if (!$doctrineRelationTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface) {
            return;
        }
        foreach ($oldToNewClasses as $oldClass => $newClass) {
            if ($doctrineRelationTagValueNode->getFullyQualifiedTargetEntity() !== $oldClass) {
                continue;
            }
            $doctrineRelationTagValueNode->changeTargetEntity($newClass);
            break;
        }
    }
    /**
     * @param string[] $oldToNewClasses
     */
    private function processSerializerTypeTagValueNode(array $oldToNewClasses, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $serializerTypeTagValueNode = $phpDocInfo->getByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode::class);
        if (!$serializerTypeTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode) {
            return;
        }
        foreach ($oldToNewClasses as $oldClass => $newClass) {
            $serializerTypeTagValueNode->replaceName($oldClass, $newClass);
        }
    }
}
