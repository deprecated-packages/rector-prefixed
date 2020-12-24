<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Rector;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Generic\NodeTypeAnalyzer\TypeProvidingExprFromClassResolver;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
abstract class AbstractToMethodCallRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function autowireAbstractToMethodCallRector(\_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoperb75b35f52b74\Rector\Generic\NodeTypeAnalyzer\TypeProvidingExprFromClassResolver $typeProvidingExprFromClassResolver) : void
    {
        $this->propertyNaming = $propertyNaming;
        $this->typeProvidingExprFromClassResolver = $typeProvidingExprFromClassResolver;
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     * @return MethodCall|PropertyFetch|Variable
     */
    protected function matchTypeProvidingExpr(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike, string $type) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        $expr = $this->typeProvidingExprFromClassResolver->resolveTypeProvidingExprFromClass($class, $functionLike, $type);
        if ($expr !== null) {
            if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
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
    private function addClassMethodParamForVariable(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable, string $type, \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : void
    {
        /** @var string $variableName */
        $variableName = $this->getName($variable);
        // add variable to __construct as dependency
        $param = $this->nodeFactory->createParamFromNameAndType($variableName, new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($type));
        $functionLike->params[] = $param;
    }
    private function addPropertyTypeToClass(string $type, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $fullyQualifiedObjectType = new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($type);
        $propertyName = $this->propertyNaming->fqnToVariableName($fullyQualifiedObjectType);
        $this->addConstructorDependencyToClass($class, $fullyQualifiedObjectType, $propertyName);
    }
    private function createPropertyFetchFromClass(string $type) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch
    {
        $thisVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this');
        $propertyName = $this->propertyNaming->fqnToVariableName($type);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch($thisVariable, $propertyName);
    }
}
