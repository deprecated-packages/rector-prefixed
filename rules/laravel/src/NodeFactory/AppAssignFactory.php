<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Laravel\NodeFactory;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScoper0a6b37af0871\Rector\Laravel\ValueObject\ServiceNameTypeAndVariableName;
final class AppAssignFactory
{
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function createAssignExpression(\_PhpScoper0a6b37af0871\Rector\Laravel\ValueObject\ServiceNameTypeAndVariableName $serviceNameTypeAndVariableName, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression
    {
        $variable = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($serviceNameTypeAndVariableName->getVariableName());
        $assign = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign($variable, $expr);
        $expression = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression($assign);
        $this->decorateWithVarAnnotation($expression, $serviceNameTypeAndVariableName);
        return $expression;
    }
    private function decorateWithVarAnnotation(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression $expression, \_PhpScoper0a6b37af0871\Rector\Laravel\ValueObject\ServiceNameTypeAndVariableName $serviceNameTypeAndVariableName) : void
    {
        $phpDocInfo = $this->phpDocInfoFactory->createEmpty($expression);
        $fullyQualifiedIdentifierTypeNode = new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode($serviceNameTypeAndVariableName->getType());
        $varTagValueNode = new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode($fullyQualifiedIdentifierTypeNode, '$' . $serviceNameTypeAndVariableName->getVariableName(), '');
        $phpDocInfo->addTagValueNode($varTagValueNode);
        $phpDocInfo->makeSingleLined();
    }
}
