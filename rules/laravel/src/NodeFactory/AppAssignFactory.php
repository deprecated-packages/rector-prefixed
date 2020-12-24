<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Laravel\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScopere8e811afab72\Rector\Laravel\ValueObject\ServiceNameTypeAndVariableName;
final class AppAssignFactory
{
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function createAssignExpression(\_PhpScopere8e811afab72\Rector\Laravel\ValueObject\ServiceNameTypeAndVariableName $serviceNameTypeAndVariableName, \_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $variable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($serviceNameTypeAndVariableName->getVariableName());
        $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($variable, $expr);
        $expression = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
        $this->decorateWithVarAnnotation($expression, $serviceNameTypeAndVariableName);
        return $expression;
    }
    private function decorateWithVarAnnotation(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression $expression, \_PhpScopere8e811afab72\Rector\Laravel\ValueObject\ServiceNameTypeAndVariableName $serviceNameTypeAndVariableName) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createEmpty($expression);
        $fullyQualifiedIdentifierTypeNode = new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode($serviceNameTypeAndVariableName->getType());
        $varTagValueNode = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode($fullyQualifiedIdentifierTypeNode, '$' . $serviceNameTypeAndVariableName->getVariableName(), '');
        $phpDocInfo->addTagValueNode($varTagValueNode);
        $phpDocInfo->makeSingleLined();
    }
}
