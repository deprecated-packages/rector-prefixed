<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\PhpParser\BuilderHelpers;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\ArgumentAdderRectorTest
 */
final class ArgumentAdderRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const ADDED_ARGUMENTS = 'added_arguments';
    /**
     * @var string
     */
    public const SCOPE_PARENT_CALL = 'parent_call';
    /**
     * @var string
     */
    public const SCOPE_METHOD_CALL = 'method_call';
    /**
     * @var string
     */
    public const SCOPE_CLASS_METHOD = 'class_method';
    /**
     * @var ArgumentAdder[]
     */
    private $addedArguments = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $exampleConfiguration = [self::ADDED_ARGUMENTS => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('SomeExampleClass', 'someMethod', 0, 'someArgument', 'true', 'SomeType')]];
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('This Rector adds new default arguments in calls of defined methods and class types.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$someObject = new SomeExampleClass;
$someObject->someMethod();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someObject = new SomeExampleClass;
$someObject->someMethod(true);
CODE_SAMPLE
, $exampleConfiguration), new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        foreach ($this->addedArguments as $addedArgument) {
            if (!$this->isObjectTypeMatch($node, $addedArgument->getClass())) {
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
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $addedArguments = $configuration[self::ADDED_ARGUMENTS] ?? [];
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($addedArguments, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder::class);
        $this->addedArguments = $addedArguments;
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    private function isObjectTypeMatch(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $type) : bool
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return $this->isObjectType($node->var, $type);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            return $this->isObjectType($node->class, $type);
        }
        // ClassMethod
        /** @var Class_|null $classLike */
        $classLike = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        // anonymous class
        if ($classLike === null) {
            return \false;
        }
        return $this->isObjectType($classLike, $type);
    }
    /**
     * @param ClassMethod|MethodCall|StaticCall $node
     */
    private function processPositionWithDefaultValues(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder $argumentAdder) : void
    {
        if ($this->shouldSkipParameter($node, $argumentAdder)) {
            return;
        }
        $defaultValue = $argumentAdder->getArgumentDefaultValue();
        $argumentType = $argumentAdder->getArgumentType();
        $position = $argumentAdder->getPosition();
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            $this->addClassMethodParam($node, $argumentAdder, $defaultValue, $argumentType, $position);
        } elseif ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            $this->processStaticCall($node, $position, $argumentAdder);
        } else {
            $arg = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg(\_PhpScoperb75b35f52b74\PhpParser\BuilderHelpers::normalizeValue($defaultValue));
            if (isset($node->args[$position])) {
                return;
            }
            $node->args[$position] = $arg;
        }
    }
    /**
     * @param ClassMethod|MethodCall|StaticCall $node
     */
    private function shouldSkipParameter(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder $argumentAdder) : bool
    {
        $position = $argumentAdder->getPosition();
        $argumentName = $argumentAdder->getArgumentName();
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            // already added?
            if (!isset($node->params[$position])) {
                return \false;
            }
            return $this->isName($node->params[$position], $argumentName);
        }
        // already added?
        if (isset($node->args[$position]) && $this->isName($node->args[$position], $argumentName)) {
            return \true;
        }
        // is correct scope?
        return !$this->isInCorrectScope($node, $argumentAdder);
    }
    /**
     * @param mixed $defaultValue
     */
    private function addClassMethodParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder $argumentAdder, $defaultValue, ?string $type, int $position) : void
    {
        $argumentName = $argumentAdder->getArgumentName();
        if ($argumentName === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $param = new \_PhpScoperb75b35f52b74\PhpParser\Node\Param(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($argumentName), \_PhpScoperb75b35f52b74\PhpParser\BuilderHelpers::normalizeValue($defaultValue));
        if ($type) {
            $param->type = \ctype_upper($type[0]) ? new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($type) : new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($type);
        }
        $classMethod->params[$position] = $param;
    }
    private function processStaticCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall, int $position, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder $argumentAdder) : void
    {
        $argumentName = $argumentAdder->getArgumentName();
        if ($argumentName === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        if (!$staticCall->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            return;
        }
        if (!$this->isName($staticCall->class, 'parent')) {
            return;
        }
        $staticCall->args[$position] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($argumentName));
    }
    /**
     * @param ClassMethod|MethodCall|StaticCall $node
     */
    private function isInCorrectScope(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder $argumentAdder) : bool
    {
        if ($argumentAdder->getScope() === null) {
            return \true;
        }
        $scope = $argumentAdder->getScope();
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            return $scope === self::SCOPE_CLASS_METHOD;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            if (!$node->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
                return \false;
            }
            if ($this->isName($node->class, 'parent')) {
                return $scope === self::SCOPE_PARENT_CALL;
            }
            return $scope === self::SCOPE_METHOD_CALL;
        }
        // MethodCall
        return $scope === self::SCOPE_METHOD_CALL;
    }
}
