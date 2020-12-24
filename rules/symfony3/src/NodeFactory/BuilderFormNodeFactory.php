<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony3\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
final class BuilderFormNodeFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function create(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $constructorClassMethod) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $formBuilderParam = $this->createBuilderParam();
        $optionsParam = $this->createOptionsParam();
        $classMethodBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder('buildForm');
        $classMethodBuilder->makePublic();
        $classMethodBuilder->addParam($formBuilderParam);
        $classMethodBuilder->addParam($optionsParam);
        // raw copy stmts from ctor
        $options = $this->replaceParameterAssignWithOptionAssign((array) $constructorClassMethod->stmts, $optionsParam);
        $classMethodBuilder->addStmts($options);
        return $classMethodBuilder->getNode();
    }
    private function createBuilderParam() : \_PhpScoperb75b35f52b74\PhpParser\Node\Param
    {
        $builderParamBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder('builder');
        $builderParamBuilder->setType(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified('_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\FormBuilderInterface'));
        return $builderParamBuilder->getNode();
    }
    private function createOptionsParam() : \_PhpScoperb75b35f52b74\PhpParser\Node\Param
    {
        $optionsParamBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder('options');
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
    private function replaceParameterAssignWithOptionAssign(array $nodes, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : array
    {
        foreach ($nodes as $expression) {
            if (!$expression instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            $node = $expression->expr;
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                continue;
            }
            $variableName = $this->nodeNameResolver->getName($node->var);
            if ($variableName === null) {
                continue;
            }
            if ($node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                $node->expr = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch($param->var, new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($variableName));
            }
        }
        return $nodes;
    }
}
