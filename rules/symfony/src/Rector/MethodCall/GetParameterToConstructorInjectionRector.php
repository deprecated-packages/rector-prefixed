<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony\Rector\MethodCall;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony\Tests\Rector\MethodCall\GetParameterToConstructorInjectionRector\GetParameterToConstructorInjectionRectorTest
 */
final class GetParameterToConstructorInjectionRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyNaming = $propertyNaming;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns fetching of parameters via `getParameter()` in ContainerAware to constructor injection in Command and Controller in Symfony', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class MyCommand extends ContainerAwareCommand
{
    public function someMethod()
    {
        $this->getParameter('someParameter');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class MyCommand extends Command
{
    private $someParameter;

    public function __construct($someParameter)
    {
        $this->someParameter = $someParameter;
    }

    public function someMethod()
    {
        $this->someParameter;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isObjectType($node->var, '_PhpScoperb75b35f52b74\\Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller')) {
            return null;
        }
        if (!$this->isName($node->name, 'getParameter')) {
            return null;
        }
        /** @var String_ $stringArgument */
        $stringArgument = $node->args[0]->value;
        $parameterName = $stringArgument->value;
        $parameterName = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::replace($parameterName, '#\\.#', '_');
        $propertyName = $this->propertyNaming->underscoreToName($parameterName);
        $classLike = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $this->addConstructorDependencyToClass($classLike, new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(), $propertyName);
        return $this->createPropertyFetch('this', $propertyName);
    }
}
