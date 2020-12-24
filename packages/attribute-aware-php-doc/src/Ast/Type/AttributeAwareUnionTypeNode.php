<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareUnionTypeNode extends \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode implements \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
{
    use AttributeTrait;
    /**
     * @var string
     * @see https://regex101.com/r/Hwk7Cg/1
     */
    private const BRACKET_WRAPPING_REGEX = '#^\\((.*?)\\)#';
    /**
     * @var bool
     */
    private $isWrappedWithBrackets = \false;
    /**
     * @param TypeNode[] $types
     */
    public function __construct(array $types, string $originalContent = '')
    {
        parent::__construct($types);
        $this->isWrappedWithBrackets = (bool) \_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($originalContent, self::BRACKET_WRAPPING_REGEX);
    }
    /**
     * Preserve common format
     */
    public function __toString() : string
    {
        if (!$this->isWrappedWithBrackets) {
            return \implode('|', $this->types);
        }
        return '(' . \implode('|', $this->types) . ')';
    }
    public function isWrappedWithBrackets() : bool
    {
        return $this->isWrappedWithBrackets;
    }
}
