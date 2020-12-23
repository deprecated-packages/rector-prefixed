<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Sensio\NodeFactory;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper0a2ac50786fa\Rector\Sensio\Helper\TemplateGuesser;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Sensio\NodeFactory\ArrayFromCompactFactory $arrayFromCompactFactory, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper0a2ac50786fa\Rector\Sensio\Helper\TemplateGuesser $templateGuesser)
    {
        $this->nodeFactory = $nodeFactory;
        $this->templateGuesser = $templateGuesser;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->arrayFromCompactFactory = $arrayFromCompactFactory;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function create(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_ $return, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode $sensioTemplateTagValueNode) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        $renderArguments = $this->resolveRenderArguments($classMethod, $return, $sensioTemplateTagValueNode);
        return $this->nodeFactory->createMethodCall('this', 'render', $renderArguments);
    }
    /**
     * @return Arg[]
     */
    private function resolveRenderArguments(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_ $return, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode $sensioTemplateTagValueNode) : array
    {
        $templateNameString = $this->resolveTemplateName($classMethod, $sensioTemplateTagValueNode);
        $arguments = [$templateNameString];
        $parametersExpr = $this->resolveParametersExpr($return, $sensioTemplateTagValueNode);
        if ($parametersExpr !== null) {
            $arguments[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($parametersExpr);
        }
        return $this->nodeFactory->createArgs($arguments);
    }
    private function resolveTemplateName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode $sensioTemplateTagValueNode) : string
    {
        if ($sensioTemplateTagValueNode->getTemplate() !== null) {
            return $sensioTemplateTagValueNode->getTemplate();
        }
        return $this->templateGuesser->resolveFromClassMethodNode($classMethod);
    }
    private function resolveParametersExpr(?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_ $return, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode $sensioTemplateTagValueNode) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        if ($sensioTemplateTagValueNode->getVars() !== []) {
            return $this->createArrayFromVars($sensioTemplateTagValueNode->getVars());
        }
        if ($return === null) {
            return null;
        }
        if ($return->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_ && \count((array) $return->expr->items)) {
            return $return->expr;
        }
        if ($return->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            $returnStaticType = $this->nodeTypeResolver->getStaticType($return->expr);
            if ($returnStaticType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
                return $return->expr;
            }
        }
        if ($return->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall && $this->nodeNameResolver->isName($return->expr, 'compact')) {
            /** @var FuncCall $compactFunCall */
            $compactFunCall = $return->expr;
            return $this->arrayFromCompactFactory->createArrayFromCompactFuncCall($compactFunCall);
        }
        return null;
    }
    /**
     * @param string[] $vars
     */
    private function createArrayFromVars(array $vars) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_
    {
        $arrayItems = [];
        foreach ($vars as $var) {
            $arrayItems[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable($var), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($var));
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_($arrayItems);
    }
}
