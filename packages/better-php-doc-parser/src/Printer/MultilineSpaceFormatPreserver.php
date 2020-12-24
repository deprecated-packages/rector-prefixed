<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Printer;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareGenericTagValueNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class MultilineSpaceFormatPreserver
{
    /**
     * @var string
     * @see https://regex101.com/r/R2zdQt/1
     */
    public const NEWLINE_WITH_SPACE_REGEX = '#\\n {1,}$#s';
    public function resolveCurrentPhpDocNodeText(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Node $node) : ?string
    {
        if ($node instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode && \property_exists($node->value, 'description')) {
            return $node->value->description;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode) {
            return $node->text;
        }
        if (!$node instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
            return null;
        }
        if (!$node->value instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
            return null;
        }
        if (\substr_count($node->value->value, "\n") > 0) {
            return $node->value->value;
        }
        return null;
    }
    /**
     * Fix multiline BC break - https://github.com/phpstan/phpdoc-parser/pull/26/files
     */
    public function fixMultilineDescriptions(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface $attributeAwareNode) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        $originalContent = $attributeAwareNode->getAttribute(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::ORIGINAL_CONTENT);
        if (!$originalContent) {
            return $attributeAwareNode;
        }
        $nodeWithRestoredSpaces = $this->restoreOriginalSpacingInText($attributeAwareNode);
        if ($nodeWithRestoredSpaces !== null) {
            $attributeAwareNode = $nodeWithRestoredSpaces;
            $attributeAwareNode->setAttribute(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::HAS_DESCRIPTION_WITH_ORIGINAL_SPACES, \true);
        }
        return $attributeAwareNode;
    }
    /**
     * @param PhpDocTextNode|AttributeAwareNodeInterface $attributeAwareNode
     */
    private function restoreOriginalSpacingInText(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface $attributeAwareNode) : ?\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        /** @var string $originalContent */
        $originalContent = $attributeAwareNode->getAttribute(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::ORIGINAL_CONTENT);
        $oldSpaces = \_PhpScopere8e811afab72\Nette\Utils\Strings::matchAll($originalContent, '#\\s+#ms');
        $currentText = $this->resolveCurrentPhpDocNodeText($attributeAwareNode);
        if ($currentText === null) {
            return null;
        }
        $newParts = \_PhpScopere8e811afab72\Nette\Utils\Strings::split($currentText, '#\\s+#');
        // we can't do this!
        if (\count($oldSpaces) + 1 !== \count($newParts)) {
            return null;
        }
        $newText = '';
        foreach ($newParts as $key => $newPart) {
            $newText .= $newPart;
            if (isset($oldSpaces[$key])) {
                if (\_PhpScopere8e811afab72\Nette\Utils\Strings::match($oldSpaces[$key][0], self::NEWLINE_WITH_SPACE_REGEX)) {
                    // remove last extra space
                    $oldSpaces[$key][0] = \_PhpScopere8e811afab72\Nette\Utils\Strings::substring($oldSpaces[$key][0], 0, -1);
                }
                $newText .= $oldSpaces[$key][0];
            }
        }
        if ($newText === '') {
            return null;
        }
        return $this->setNewTextToPhpDocNode($attributeAwareNode, $newText);
    }
    private function setNewTextToPhpDocNode(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface $attributeAwareNode, string $newText) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        if ($attributeAwareNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode && \property_exists($attributeAwareNode->value, 'description')) {
            $attributeAwareNode->value->description = $newText;
        }
        if ($attributeAwareNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode) {
            $attributeAwareNode->text = $newText;
        }
        if ($attributeAwareNode instanceof \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode && $attributeAwareNode->value instanceof \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareGenericTagValueNode) {
            $attributeAwareNode->value->value = $newText;
        }
        return $attributeAwareNode;
    }
}
