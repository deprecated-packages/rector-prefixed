<?php

declare (strict_types=1);
namespace Rector\Symfony3\NodeFactory;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\PhpParser\Builder\MethodBuilder;
use Rector\Core\PhpParser\Builder\ParamBuilder;
use Rector\NodeNameResolver\NodeNameResolver;
final class BuilderFormNodeFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function create(\PhpParser\Node\Stmt\ClassMethod $constructorClassMethod) : \PhpParser\Node\Stmt\ClassMethod
    {
        $formBuilderParam = $this->createBuilderParam();
        $optionsParam = $this->createOptionsParam();
        $classMethodBuilder = new \Rector\Core\PhpParser\Builder\MethodBuilder('buildForm');
        $classMethodBuilder->makePublic();
        $classMethodBuilder->addParam($formBuilderParam);
        $classMethodBuilder->addParam($optionsParam);
        // raw copy stmts from ctor
        $options = $this->replaceParameterAssignWithOptionAssign((array) $constructorClassMethod->stmts, $optionsParam);
        $classMethodBuilder->addStmts($options);
        return $classMethodBuilder->getNode();
    }
    private function createBuilderParam() : \PhpParser\Node\Param
    {
        $builderParamBuilder = new \Rector\Core\PhpParser\Builder\ParamBuilder('builder');
        $builderParamBuilder->setType(new \PhpParser\Node\Name\FullyQualified('_PhpScoper267b3276efc2\\Symfony\\Component\\Form\\FormBuilderInterface'));
        return $builderParamBuilder->getNode();
    }
    private function createOptionsParam() : \PhpParser\Node\Param
    {
        $optionsParamBuilder = new \Rector\Core\PhpParser\Builder\ParamBuilder('options');
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
    private function replaceParameterAssignWithOptionAssign(array $nodes, \PhpParser\Node\Param $param) : array
    {
        foreach ($nodes as $expression) {
            if (!$expression instanceof \PhpParser\Node\Stmt\Expression) {
                continue;
            }
            $node = $expression->expr;
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                continue;
            }
            $variableName = $this->nodeNameResolver->getName($node->var);
            if ($variableName === null) {
                continue;
            }
            if ($node->expr instanceof \PhpParser\Node\Expr\Variable) {
                $node->expr = new \PhpParser\Node\Expr\ArrayDimFetch($param->var, new \PhpParser\Node\Scalar\String_($variableName));
            }
        }
        return $nodes;
    }
}
