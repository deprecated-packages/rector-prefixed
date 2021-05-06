<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\New_;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Type\ObjectType;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Naming\Naming\PropertyNaming;
use Rector\Naming\ValueObject\ExpectedName;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Transform\NodeFactory\PropertyFetchFactory;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\Transform\Rector\New_\NewToConstructorInjectionRector\NewToConstructorInjectionRectorTest
 */
final class NewToConstructorInjectionRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const TYPES_TO_CONSTRUCTOR_INJECTION = 'types_to_constructor_injection';
    /**
     * @var ObjectType[]
     */
    private $constructorInjectionObjectTypes = [];
    /**
     * @var \Rector\Transform\NodeFactory\PropertyFetchFactory
     */
    private $propertyFetchFactory;
    /**
     * @var \Rector\Naming\Naming\PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\Rector\Transform\NodeFactory\PropertyFetchFactory $propertyFetchFactory, \Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyFetchFactory = $propertyFetchFactory;
        $this->propertyNaming = $propertyNaming;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change defined new type to constructor injection', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $validator = new Validator();
        $validator->validate(1000);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var Validator
     */
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function run()
    {
        $this->validator->validate(1000);
    }
}
CODE_SAMPLE
, [self::TYPES_TO_CONSTRUCTOR_INJECTION => ['Validator']])]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\New_::class, \PhpParser\Node\Expr\Assign::class, \PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param New_|Assign|MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Expr\MethodCall) {
            return $this->refactorMethodCall($node);
        }
        if ($node instanceof \PhpParser\Node\Expr\Assign) {
            $this->refactorAssign($node);
        }
        if ($node instanceof \PhpParser\Node\Expr\New_) {
            $this->refactorNew($node);
        }
        return null;
    }
    /**
     * @param array<string, mixed[]> $configuration
     */
    public function configure(array $configuration) : void
    {
        $typesToConstructorInjections = $configuration[self::TYPES_TO_CONSTRUCTOR_INJECTION] ?? [];
        foreach ($typesToConstructorInjections as $typeToConstructorInjection) {
            $this->constructorInjectionObjectTypes[] = new \PHPStan\Type\ObjectType($typeToConstructorInjection);
        }
    }
    private function refactorMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : ?\PhpParser\Node\Expr\MethodCall
    {
        foreach ($this->constructorInjectionObjectTypes as $constructorInjectionObjectType) {
            if (!$methodCall->var instanceof \PhpParser\Node\Expr\Variable) {
                continue;
            }
            if (!$this->isObjectType($methodCall->var, $constructorInjectionObjectType)) {
                continue;
            }
            if (!$this->nodeTypeResolver->isObjectType($methodCall->var, $constructorInjectionObjectType)) {
                continue;
            }
            $methodCall->var = $this->propertyFetchFactory->createFromType($constructorInjectionObjectType);
            return $methodCall;
        }
        return null;
    }
    private function refactorAssign(\PhpParser\Node\Expr\Assign $assign) : void
    {
        if (!$assign->expr instanceof \PhpParser\Node\Expr\New_) {
            return;
        }
        foreach ($this->constructorInjectionObjectTypes as $constructorInjectionObjectType) {
            if (!$this->isObjectType($assign->expr, $constructorInjectionObjectType)) {
                continue;
            }
            $this->removeNode($assign);
        }
    }
    private function refactorNew(\PhpParser\Node\Expr\New_ $new) : void
    {
        foreach ($this->constructorInjectionObjectTypes as $constructorInjectionObjectType) {
            if (!$this->isObjectType($new->class, $constructorInjectionObjectType)) {
                continue;
            }
            $classLike = $new->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
                continue;
            }
            $expectedPropertyName = $this->propertyNaming->getExpectedNameFromType($constructorInjectionObjectType);
            if (!$expectedPropertyName instanceof \Rector\Naming\ValueObject\ExpectedName) {
                continue;
            }
            $this->addConstructorDependencyToClass($classLike, $constructorInjectionObjectType, $expectedPropertyName->getName());
        }
    }
}
