<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadDocBlock;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\TypeComparator;
final class DeadReturnTagValueNodeAnalyzer
{
    /**
     * @var TypeComparator
     */
    private $typeComparator;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\TypeComparator $typeComparator)
    {
        $this->typeComparator = $typeComparator;
    }
    public function isDead(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
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
