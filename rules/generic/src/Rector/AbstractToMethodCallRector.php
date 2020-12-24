<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\NodeTypeAnalyzer\TypeProvidingExprFromClassResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\PropertyNaming;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
abstract class AbstractToMethodCallRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @var TypeProvidingExprFromClassResolver
     */
    private $typeProvidingExprFromClassResolver;
    /**
     * @required
     */
    public function autowireAbstractToMethodCallRector(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoper2a4e7ab1ecbc\Rector\Generic\NodeTypeAnalyzer\TypeProvidingExprFromClassResolver $typeProvidingExprFromClassResolver) : void
    {
        $this->propertyNaming = $propertyNaming;
        $this->typeProvidingExprFromClassResolver = $typeProvidingExprFromClassResolver;
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     * @return MethodCall|PropertyFetch|Variable
     */
    protected function matchTypeProvidingExpr(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike, string $type) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        $expr = $this->typeProvidingExprFromClassResolver->resolveTypeProvidingExprFromClass($class, $functionLike, $type);
        if ($expr !== null) {
            if ($expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
                $this->addClassMethodParamForVariable($expr, $type, $functionLike);
            }
            return $expr;
        }
        $this->addPropertyTypeToClass($type, $class);
        return $this->createPropertyFetchFromClass($type);
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    private function addClassMethodParamForVariable(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable, string $type, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionLike) : void
    {
        /** @var string $variableName */
        $variableName = $this->getName($variable);
        // add variable to __construct as dependency
        $param = $this->nodeFactory->createParamFromNameAndType($variableName, new \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($type));
        $functionLike->params[] = $param;
    }
    private function addPropertyTypeToClass(string $type, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $fullyQualifiedObjectType = new \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($type);
        $propertyName = $this->propertyNaming->fqnToVariableName($fullyQualifiedObjectType);
        $this->addConstructorDependencyToClass($class, $fullyQualifiedObjectType, $propertyName);
    }
    private function createPropertyFetchFromClass(string $type) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch
    {
        $thisVariable = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('this');
        $propertyName = $this->propertyNaming->fqnToVariableName($type);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch($thisVariable, $propertyName);
    }
}
