<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Sensio\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\Sensio\Helper\TemplateGuesser;
final class ThisRenderFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var TemplateGuesser
     */
    private $templateGuesser;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ArrayFromCompactFactory
     */
    private $arrayFromCompactFactory;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Sensio\NodeFactory\ArrayFromCompactFactory $arrayFromCompactFactory, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\Sensio\Helper\TemplateGuesser $templateGuesser)
    {
        $this->nodeFactory = $nodeFactory;
        $this->templateGuesser = $templateGuesser;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->arrayFromCompactFactory = $arrayFromCompactFactory;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function create(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ $return, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode $sensioTemplateTagValueNode) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        $renderArguments = $this->resolveRenderArguments($classMethod, $return, $sensioTemplateTagValueNode);
        return $this->nodeFactory->createMethodCall('this', 'render', $renderArguments);
    }
    /**
     * @return Arg[]
     */
    private function resolveRenderArguments(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ $return, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode $sensioTemplateTagValueNode) : array
    {
        $templateNameString = $this->resolveTemplateName($classMethod, $sensioTemplateTagValueNode);
        $arguments = [$templateNameString];
        $parametersExpr = $this->resolveParametersExpr($return, $sensioTemplateTagValueNode);
        if ($parametersExpr !== null) {
            $arguments[] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($parametersExpr);
        }
        return $this->nodeFactory->createArgs($arguments);
    }
    private function resolveTemplateName(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode $sensioTemplateTagValueNode) : string
    {
        if ($sensioTemplateTagValueNode->getTemplate() !== null) {
            return $sensioTemplateTagValueNode->getTemplate();
        }
        return $this->templateGuesser->resolveFromClassMethodNode($classMethod);
    }
    private function resolveParametersExpr(?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ $return, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode $sensioTemplateTagValueNode) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($sensioTemplateTagValueNode->getVars() !== []) {
            return $this->createArrayFromVars($sensioTemplateTagValueNode->getVars());
        }
        if ($return === null) {
            return null;
        }
        if ($return->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_ && \count((array) $return->expr->items)) {
            return $return->expr;
        }
        if ($return->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            $returnStaticType = $this->nodeTypeResolver->getStaticType($return->expr);
            if ($returnStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                return $return->expr;
            }
        }
        if ($return->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall && $this->nodeNameResolver->isName($return->expr, 'compact')) {
            /** @var FuncCall $compactFunCall */
            $compactFunCall = $return->expr;
            return $this->arrayFromCompactFactory->createArrayFromCompactFuncCall($compactFunCall);
        }
        return null;
    }
    /**
     * @param string[] $vars
     */
    private function createArrayFromVars(array $vars) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_
    {
        $arrayItems = [];
        foreach ($vars as $var) {
            $arrayItems[] = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($var), new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($var));
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_($arrayItems);
    }
}
