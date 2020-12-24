<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadDocBlock;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\TypeComparator;
final class DeadReturnTagValueNodeAnalyzer
{
    /**
     * @var TypeComparator
     */
    private $typeComparator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\TypeComparator $typeComparator)
    {
        $this->typeComparator = $typeComparator;
    }
    public function isDead(\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode $returnTagValueNode, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
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
