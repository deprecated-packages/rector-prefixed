<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Symfony3\NodeFactory;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\ParamBuilder;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
final class BuilderFormNodeFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function create(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $constructorClassMethod) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod
    {
        $formBuilderParam = $this->createBuilderParam();
        $optionsParam = $this->createOptionsParam();
        $classMethodBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder('buildForm');
        $classMethodBuilder->makePublic();
        $classMethodBuilder->addParam($formBuilderParam);
        $classMethodBuilder->addParam($optionsParam);
        // raw copy stmts from ctor
        $options = $this->replaceParameterAssignWithOptionAssign((array) $constructorClassMethod->stmts, $optionsParam);
        $classMethodBuilder->addStmts($options);
        return $classMethodBuilder->getNode();
    }
    private function createBuilderParam() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Param
    {
        $builderParamBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\ParamBuilder('builder');
        $builderParamBuilder->setType(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified('_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\FormBuilderInterface'));
        return $builderParamBuilder->getNode();
    }
    private function createOptionsParam() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Param
    {
        $optionsParamBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\ParamBuilder('options');
        $optionsParamBuilder->setType('array');
        return $optionsParamBuilder->getNode();
    }
    /**
     * @param Node[] $nodes
     * @return Node[]
     *
     * $this->value = $value
     * ↓
     * $this->value = $options['value']
     */
    private function replaceParameterAssignWithOptionAssign(array $nodes, \_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param) : array
    {
        foreach ($nodes as $expression) {
            if (!$expression instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            $node = $expression->expr;
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
                continue;
            }
            $variableName = $this->nodeNameResolver->getName($node->var);
            if ($variableName === null) {
                continue;
            }
            if ($node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
                $node->expr = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch($param->var, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($variableName));
            }
        }
        return $nodes;
    }
}
