<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Laravel\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScoperb75b35f52b74\Rector\Laravel\ValueObject\ServiceNameTypeAndVariableName;
final class AppAssignFactory
{
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function createAssignExpression(\_PhpScoperb75b35f52b74\Rector\Laravel\ValueObject\ServiceNameTypeAndVariableName $serviceNameTypeAndVariableName, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression
    {
        $variable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($serviceNameTypeAndVariableName->getVariableName());
        $assign = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($variable, $expr);
        $expression = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($assign);
        $this->decorateWithVarAnnotation($expression, $serviceNameTypeAndVariableName);
        return $expression;
    }
    private function decorateWithVarAnnotation(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression $expression, \_PhpScoperb75b35f52b74\Rector\Laravel\ValueObject\ServiceNameTypeAndVariableName $serviceNameTypeAndVariableName) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createEmpty($expression);
        $fullyQualifiedIdentifierTypeNode = new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode($serviceNameTypeAndVariableName->getType());
        $varTagValueNode = new \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode($fullyQualifiedIdentifierTypeNode, '$' . $serviceNameTypeAndVariableName->getVariableName(), '');
        $phpDocInfo->addTagValueNode($varTagValueNode);
        $phpDocInfo->makeSingleLined();
    }
}
