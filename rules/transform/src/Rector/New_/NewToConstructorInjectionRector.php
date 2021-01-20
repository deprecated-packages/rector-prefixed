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
 * @see \Rector\Transform\Tests\Rector\New_\NewToConstructorInjectionRector\NewToConstructorInjectionRectorTest
 */
final class NewToConstructorInjectionRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const TYPES_TO_CONSTRUCTOR_INJECTION = 'TYPES_TO_CONSTRUCTOR_INJECTION';
    /**
     * @var string[]
     */
    private $typesToConstructorInjection = [];
    /**
     * @var PropertyFetchFactory
     */
    private $propertyFetchFactory;
    /**
     * @var PropertyNaming
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
     * @return string[]
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
    public function configure(array $configuration) : void
    {
        $this->typesToConstructorInjection = $configuration[self::TYPES_TO_CONSTRUCTOR_INJECTION] ?? [];
    }
    private function refactorMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : ?\PhpParser\Node\Expr\MethodCall
    {
        foreach ($this->typesToConstructorInjection as $typeToConstructorInjection) {
            if (!$methodCall->var instanceof \PhpParser\Node\Expr\Variable) {
                continue;
            }
            if (!$this->isObjectType($methodCall->var, $typeToConstructorInjection)) {
                continue;
            }
            $methodCall->var = $this->propertyFetchFactory->createFromType($typeToConstructorInjection);
            return $methodCall;
        }
        return null;
    }
    private function refactorAssign(\PhpParser\Node\Expr\Assign $assign) : void
    {
        if (!$assign->expr instanceof \PhpParser\Node\Expr\New_) {
            return;
        }
        foreach ($this->typesToConstructorInjection as $typesToConstructorInjection) {
            if (!$this->isObjectType($assign->expr, $typesToConstructorInjection)) {
                continue;
            }
            $this->removeNode($assign);
        }
    }
    private function refactorNew(\PhpParser\Node\Expr\New_ $new) : void
    {
        foreach ($this->typesToConstructorInjection as $typeToConstructorInjection) {
            if (!$this->isObjectType($new->class, $typeToConstructorInjection)) {
                continue;
            }
            $classLike = $new->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
                continue;
            }
            $objectType = new \PHPStan\Type\ObjectType($typeToConstructorInjection);
            $expectedPropertyName = $this->propertyNaming->getExpectedNameFromType($objectType);
            if (!$expectedPropertyName instanceof \Rector\Naming\ValueObject\ExpectedName) {
                continue;
            }
            $this->addConstructorDependencyToClass($classLike, $objectType, $expectedPropertyName->getName());
        }
    }
}
