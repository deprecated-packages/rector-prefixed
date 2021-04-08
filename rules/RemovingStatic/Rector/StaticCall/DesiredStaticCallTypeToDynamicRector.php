<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Rector\StaticCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PHPStan\Type\ObjectType;
use Rector\Core\Configuration\Option;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\Naming\Naming\PropertyNaming;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20210408\Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\RemovingStatic\Rector\StaticCall\DesiredStaticCallTypeToDynamicRector\DesiredStaticCallTypeToDynamicRectorTest
 */
final class DesiredStaticCallTypeToDynamicRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ObjectType[]
     */
    private $staticObjectTypes = [];
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\Rector\Naming\Naming\PropertyNaming $propertyNaming, \RectorPrefix20210408\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $typesToRemoveStaticFrom = $parameterProvider->provideArrayParameter(\Rector\Core\Configuration\Option::TYPES_TO_REMOVE_STATIC_FROM);
        foreach ($typesToRemoveStaticFrom as $typeToRemoveStaticFrom) {
            $this->staticObjectTypes[] = new \PHPStan\Type\ObjectType($typeToRemoveStaticFrom);
        }
        $this->propertyNaming = $propertyNaming;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change defined static service to dynamic one', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        SomeStaticMethod::someStatic();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $this->someStaticMethod::someStatic();
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->staticObjectTypes as $staticObjectType) {
            if (!$this->isObjectType($node->class, $staticObjectType)) {
                continue;
            }
            // is the same class or external call?
            $className = $this->getName($node->class);
            if ($className === 'self') {
                return $this->createFromSelf($node);
            }
            $propertyName = $this->propertyNaming->fqnToVariableName($staticObjectType);
            $currentMethodName = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
            if ($currentMethodName === \Rector\Core\ValueObject\MethodName::CONSTRUCT) {
                $propertyFetch = new \PhpParser\Node\Expr\Variable($propertyName);
            } else {
                $propertyFetch = new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), $propertyName);
            }
            return new \PhpParser\Node\Expr\MethodCall($propertyFetch, $node->name, $node->args);
        }
        return null;
    }
    private function createFromSelf(\PhpParser\Node\Expr\StaticCall $staticCall) : \PhpParser\Node\Expr\MethodCall
    {
        return new \PhpParser\Node\Expr\MethodCall(new \PhpParser\Node\Expr\Variable('this'), $staticCall->name, $staticCall->args);
    }
}
