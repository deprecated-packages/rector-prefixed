<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
final class AttributeAwareParamTagValueNode extends \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode implements \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface
{
    use AttributeTrait;
    /**
     * @var bool
     */
    private $isReference = \false;
    /**
     * The constructor override is needed to add support for reference &
     * @see https://github.com/rectorphp/rector/issues/1734
     */
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, bool $isVariadic, string $parameterName, string $description, bool $isReference)
    {
        parent::__construct($typeNode, $isVariadic, $parameterName, $description);
        $this->isReference = $isReference;
    }
    public function __toString() : string
    {
        $variadic = $this->isVariadic ? '...' : '';
        $reference = $this->isReference ? '&' : '';
        $content = \sprintf('%s %s%s%s %s', $this->type, $variadic, $reference, $this->parameterName, $this->description);
        return \trim($content);
    }
    public function isReference() : bool
    {
        return $this->isReference;
    }
}
