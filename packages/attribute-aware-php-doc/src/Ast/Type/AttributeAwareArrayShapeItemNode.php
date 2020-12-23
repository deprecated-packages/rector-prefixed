<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\Type;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
final class AttributeAwareArrayShapeItemNode extends \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\ArrayShapeItemNode implements \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
{
    use AttributeTrait;
    /**
     * @var bool
     */
    private $hasSpaceAfterDoubleColon = \false;
    /**
     * @param ConstExprIntegerNode|ConstExprStringNode|IdentifierTypeNode|null $keyName
     */
    public function __construct($keyName, bool $optional, \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, string $docComment = '')
    {
        parent::__construct($keyName, $optional, $typeNode);
        // spaces after double colon
        $keyWithSpacePattern = $this->createKeyWithSpacePattern($keyName, $optional);
        $this->hasSpaceAfterDoubleColon = (bool) \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::matchAll($docComment, $keyWithSpacePattern);
    }
    public function __toString() : string
    {
        if ($this->keyName === null) {
            return (string) $this->valueType;
        }
        return \sprintf('%s%s:%s%s', (string) $this->keyName, $this->optional ? '?' : '', $this->hasSpaceAfterDoubleColon ? ' ' : '', (string) $this->valueType);
    }
    /**
     * @param ConstExprIntegerNode|IdentifierTypeNode|null $keyName
     */
    private function createKeyWithSpacePattern($keyName, bool $optional) : string
    {
        $keyNameString = (string) $keyName;
        if ($optional) {
            $keyNameString .= '?';
        }
        $keyNameStringPregQuoted = \preg_quote($keyNameString);
        return \sprintf('#%s\\:\\s+#', $keyNameStringPregQuoted);
    }
}
