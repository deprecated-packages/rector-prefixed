<?php

declare (strict_types=1);
namespace Rector\DeadDocBlock;

use PhpParser\Node\FunctionLike;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode;
use Rector\NodeTypeResolver\TypeComparator\TypeComparator;
final class DeadReturnTagValueNodeAnalyzer
{
    /**
     * @var TypeComparator
     */
    private $typeComparator;
    public function __construct(\Rector\NodeTypeResolver\TypeComparator\TypeComparator $typeComparator)
    {
        $this->typeComparator = $typeComparator;
    }
    public function isDead(\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \PhpParser\Node\FunctionLike $functionLike) : bool
    {
        $returnType = $functionLike->getReturnType();
        if ($returnType === null) {
            return \false;
        }
        if (!$this->typeComparator->arePhpParserAndPhpStanPhpDocTypesEqual($returnType, $returnTagValueNode->type, $functionLike)) {
            return \false;
        }
        if ($returnTagValueNode->type instanceof \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode) {
            return \false;
        }
        return $returnTagValueNode->description === '';
    }
}
