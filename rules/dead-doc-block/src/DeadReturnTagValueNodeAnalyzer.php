<?php

declare (strict_types=1);
namespace Rector\DeadDocBlock;

use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use Rector\NodeTypeResolver\PHPStan\TypeComparator;
final class DeadReturnTagValueNodeAnalyzer
{
    /**
     * @var TypeComparator
     */
    private $typeComparator;
    public function __construct(\Rector\NodeTypeResolver\PHPStan\TypeComparator $typeComparator)
    {
        $this->typeComparator = $typeComparator;
    }
    public function isDead(\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $returnType = $classMethod->getReturnType();
        if ($returnType === null) {
            return \false;
        }
        if (!$this->typeComparator->arePhpParserAndPhpStanPhpDocTypesEqual($returnType, $returnTagValueNode->type, $classMethod)) {
            return \false;
        }
        return $returnTagValueNode->description === '';
    }
}
