<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Printer;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Node;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareGenericTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class MultilineSpaceFormatPreserver
{
    /**
     * @var string
     * @see https://regex101.com/r/R2zdQt/1
     */
    public const NEWLINE_WITH_SPACE_REGEX = '#\\n {1,}$#s';
    public function resolveCurrentPhpDocNodeText(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Node $node) : ?string
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode && \property_exists($node->value, 'description')) {
            return $node->value->description;
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode) {
            return $node->text;
        }
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
            return null;
        }
        if (!$node->value instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
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
    public function fixMultilineDescriptions(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface $attributeAwareNode) : \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        $originalContent = $attributeAwareNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::ORIGINAL_CONTENT);
        if (!$originalContent) {
            return $attributeAwareNode;
        }
        $nodeWithRestoredSpaces = $this->restoreOriginalSpacingInText($attributeAwareNode);
        if ($nodeWithRestoredSpaces !== null) {
            $attributeAwareNode = $nodeWithRestoredSpaces;
            $attributeAwareNode->setAttribute(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::HAS_DESCRIPTION_WITH_ORIGINAL_SPACES, \true);
        }
        return $attributeAwareNode;
    }
    /**
     * @param PhpDocTextNode|AttributeAwareNodeInterface $attributeAwareNode
     */
    private function restoreOriginalSpacingInText(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface $attributeAwareNode) : ?\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        /** @var string $originalContent */
        $originalContent = $attributeAwareNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Attributes\Attribute\Attribute::ORIGINAL_CONTENT);
        $oldSpaces = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::matchAll($originalContent, '#\\s+#ms');
        $currentText = $this->resolveCurrentPhpDocNodeText($attributeAwareNode);
        if ($currentText === null) {
            return null;
        }
        $newParts = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::split($currentText, '#\\s+#');
        // we can't do this!
        if (\count($oldSpaces) + 1 !== \count($newParts)) {
            return null;
        }
        $newText = '';
        foreach ($newParts as $key => $newPart) {
            $newText .= $newPart;
            if (isset($oldSpaces[$key])) {
                if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::match($oldSpaces[$key][0], self::NEWLINE_WITH_SPACE_REGEX)) {
                    // remove last extra space
                    $oldSpaces[$key][0] = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::substring($oldSpaces[$key][0], 0, -1);
                }
                $newText .= $oldSpaces[$key][0];
            }
        }
        if ($newText === '') {
            return null;
        }
        return $this->setNewTextToPhpDocNode($attributeAwareNode, $newText);
    }
    private function setNewTextToPhpDocNode(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface $attributeAwareNode, string $newText) : \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        if ($attributeAwareNode instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode && \property_exists($attributeAwareNode->value, 'description')) {
            $attributeAwareNode->value->description = $newText;
        }
        if ($attributeAwareNode instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTextNode) {
            $attributeAwareNode->text = $newText;
        }
        if ($attributeAwareNode instanceof \_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode && $attributeAwareNode->value instanceof \_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareGenericTagValueNode) {
            $attributeAwareNode->value->value = $newText;
        }
        return $attributeAwareNode;
    }
}
