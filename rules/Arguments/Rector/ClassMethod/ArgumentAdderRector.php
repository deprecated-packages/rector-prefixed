<?php

declare (strict_types=1);
namespace Rector\Arguments\Rector\ClassMethod;

use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ObjectType;
use Rector\Arguments\NodeAnalyzer\ArgumentAddingScope;
use Rector\Arguments\ValueObject\ArgumentAdder;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210317\Webmozart\Assert\Assert;
/**
 * @see \Rector\Tests\Arguments\Rector\ClassMethod\ArgumentAdderRector\ArgumentAdderRectorTest
 */
final class ArgumentAdderRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const ADDED_ARGUMENTS = 'added_arguments';
    /**
     * @var ArgumentAdder[]
     */
    private $addedArguments = [];
    /**
     * @var ArgumentAddingScope
     */
    private $argumentAddingScope;
    public function __construct(\Rector\Arguments\NodeAnalyzer\ArgumentAddingScope $argumentAddingScope)
    {
        $this->argumentAddingScope = $argumentAddingScope;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $exampleConfiguration = [self::ADDED_ARGUMENTS => [new \Rector\Arguments\ValueObject\ArgumentAdder('SomeExampleClass', 'someMethod', 0, 'someArgument', 'true', 'SomeType')]];
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('This Rector adds new default arguments in calls of defined methods and class types.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$someObject = new SomeExampleClass;
$someObject->someMethod();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someObject = new SomeExampleClass;
$someObject->someMethod(true);
CODE_SAMPLE
, $exampleConfiguration), new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class MyCustomClass extends SomeExampleClass
{
    public function someMethod()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class MyCustomClass extends SomeExampleClass
{
    public function someMethod($value = true)
    {
    }
}
CODE_SAMPLE
, $exampleConfiguration)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Expr\StaticCall::class, \PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        foreach ($this->addedArguments as $addedArgument) {
            if (!$this->isObjectTypeMatch($node, $addedArgument->getObjectType())) {
                continue;
            }
            if (!$this->isName($node->name, $addedArgument->getMethod())) {
                continue;
            }
            $this->processPositionWithDefaultValues($node, $addedArgument);
        }
        return $node;
    }
    /**
     * @param array<string, ArgumentAdder[]> $configuration
     */
    public function configure($configuration) : void
    {
        $addedArguments = $configuration[self::ADDED_ARGUMENTS] ?? [];
        \RectorPrefix20210317\Webmozart\Assert\Assert::allIsInstanceOf($addedArguments, \Rector\Arguments\ValueObject\ArgumentAdder::class);
        $this->addedArguments = $addedArguments;
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     * @param \PHPStan\Type\ObjectType $objectType
     */
    private function isObjectTypeMatch($node, $objectType) : bool
    {
        if ($node instanceof \PhpParser\Node\Expr\MethodCall) {
            return $this->isObjectType($node->var, $objectType);
        }
        if ($node instanceof \PhpParser\Node\Expr\StaticCall) {
            return $this->isObjectType($node->class, $objectType);
        }
        // ClassMethod
        /** @var Class_|null $classLike */
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        // anonymous class
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        return $this->isObjectType($classLike, $objectType);
    }
    /**
     * @param ClassMethod|MethodCall|StaticCall $node
     * @param \Rector\Arguments\ValueObject\ArgumentAdder $argumentAdder
     */
    private function processPositionWithDefaultValues($node, $argumentAdder) : void
    {
        if ($this->shouldSkipParameter($node, $argumentAdder)) {
            return;
        }
        $defaultValue = $argumentAdder->getArgumentDefaultValue();
        $argumentType = $argumentAdder->getArgumentType();
        $position = $argumentAdder->getPosition();
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            $this->addClassMethodParam($node, $argumentAdder, $defaultValue, $argumentType, $position);
        } elseif ($node instanceof \PhpParser\Node\Expr\StaticCall) {
            $this->processStaticCall($node, $position, $argumentAdder);
        } else {
            $arg = new \PhpParser\Node\Arg(\PhpParser\BuilderHelpers::normalizeValue($defaultValue));
            if (isset($node->args[$position])) {
                return;
            }
            $node->args[$position] = $arg;
        }
    }
    /**
     * @param ClassMethod|MethodCall|StaticCall $node
     * @param \Rector\Arguments\ValueObject\ArgumentAdder $argumentAdder
     */
    private function shouldSkipParameter($node, $argumentAdder) : bool
    {
        $position = $argumentAdder->getPosition();
        $argumentName = $argumentAdder->getArgumentName();
        if ($argumentName === null) {
            return \true;
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            // already added?
            if (!isset($node->params[$position])) {
                return \false;
            }
            return $this->isName($node->params[$position], $argumentName);
        }
        // already added?
        if (!isset($node->args[$position])) {
            // is correct scope?
            return !$this->argumentAddingScope->isInCorrectScope($node, $argumentAdder);
        }
        if (!$this->isName($node->args[$position], $argumentName)) {
            // is correct scope?
            return !$this->argumentAddingScope->isInCorrectScope($node, $argumentAdder);
        }
        return \true;
    }
    /**
     * @param mixed $defaultValue
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     * @param \Rector\Arguments\ValueObject\ArgumentAdder $argumentAdder
     * @param string|null $type
     * @param int $position
     */
    private function addClassMethodParam($classMethod, $argumentAdder, $defaultValue, $type, $position) : void
    {
        $argumentName = $argumentAdder->getArgumentName();
        if ($argumentName === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $param = new \PhpParser\Node\Param(new \PhpParser\Node\Expr\Variable($argumentName), \PhpParser\BuilderHelpers::normalizeValue($defaultValue));
        if ($type) {
            $param->type = \ctype_upper($type[0]) ? new \PhpParser\Node\Name\FullyQualified($type) : new \PhpParser\Node\Identifier($type);
        }
        $classMethod->params[$position] = $param;
    }
    /**
     * @param \PhpParser\Node\Expr\StaticCall $staticCall
     * @param int $position
     * @param \Rector\Arguments\ValueObject\ArgumentAdder $argumentAdder
     */
    private function processStaticCall($staticCall, $position, $argumentAdder) : void
    {
        $argumentName = $argumentAdder->getArgumentName();
        if ($argumentName === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        if (!$staticCall->class instanceof \PhpParser\Node\Name) {
            return;
        }
        if (!$this->isName($staticCall->class, 'parent')) {
            return;
        }
        $staticCall->args[$position] = new \PhpParser\Node\Arg(new \PhpParser\Node\Expr\Variable($argumentName));
    }
}
