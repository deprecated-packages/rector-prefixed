<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit;

use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
/**
 * @see \Rector\BetterPhpDocParser\PhpDocNodeFactory\StringMatchingPhpDocNodeFactory\PHPUnitExpectedExceptionDocNodeFactory
 */
final class PHPUnitExpectedExceptionTagValueNode implements \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode, \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
{
    use AttributeTrait;
    /**
     * @var string
     */
    public const NAME = '@expectedException';
    /**
     * @var TypeNode
     */
    private $typeNode;
    /**
     * @param \PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode
     */
    public function __construct($typeNode)
    {
        $this->typeNode = $typeNode;
    }
    public function __toString() : string
    {
        return (string) $this->typeNode;
    }
    public function getTypeNode() : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        return $this->typeNode;
    }
}
