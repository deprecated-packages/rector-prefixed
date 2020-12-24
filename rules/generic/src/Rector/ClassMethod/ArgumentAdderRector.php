<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\BuilderHelpers;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\ClassMethod\ArgumentAdderRector\ArgumentAdderRectorTest
 */
final class ArgumentAdderRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $exampleConfiguration = [self::ADDED_ARGUMENTS => [new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder('SomeExampleClass', 'someMethod', 0, 'someArgument', 'true', 'SomeType')]];
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('This Rector adds new default arguments in calls of defined methods and class types.', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$someObject = new SomeExampleClass;
$someObject->someMethod();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someObject = new SomeExampleClass;
$someObject->someMethod(true);
CODE_SAMPLE
, $exampleConfiguration), new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
        \_PhpScoper0a6b37af0871\Webmozart\Assert\Assert::allIsInstanceOf($addedArguments, \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder::class);
        $this->addedArguments = $addedArguments;
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    private function isObjectTypeMatch(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $type) : bool
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return $this->isObjectType($node->var, $type);
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            return $this->isObjectType($node->class, $type);
        }
        // ClassMethod
        /** @var Class_|null $classLike */
        $classLike = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        // anonymous class
        if ($classLike === null) {
            return \false;
        }
        return $this->isObjectType($classLike, $type);
    }
    /**
     * @param ClassMethod|MethodCall|StaticCall $node
     */
    private function processPositionWithDefaultValues(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder $argumentAdder) : void
    {
        if ($this->shouldSkipParameter($node, $argumentAdder)) {
            return;
        }
        $defaultValue = $argumentAdder->getArgumentDefaultValue();
        $argumentType = $argumentAdder->getArgumentType();
        $position = $argumentAdder->getPosition();
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
            $this->addClassMethodParam($node, $argumentAdder, $defaultValue, $argumentType, $position);
        } elseif ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            $this->processStaticCall($node, $position, $argumentAdder);
        } else {
            $arg = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg(\_PhpScoper0a6b37af0871\PhpParser\BuilderHelpers::normalizeValue($defaultValue));
            if (isset($node->args[$position])) {
                return;
            }
            $node->args[$position] = $arg;
        }
    }
    /**
     * @param ClassMethod|MethodCall|StaticCall $node
     */
    private function shouldSkipParameter(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder $argumentAdder) : bool
    {
        $position = $argumentAdder->getPosition();
        $argumentName = $argumentAdder->getArgumentName();
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
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
    private function addClassMethodParam(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder $argumentAdder, $defaultValue, ?string $type, int $position) : void
    {
        $argumentName = $argumentAdder->getArgumentName();
        if ($argumentName === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        $param = new \_PhpScoper0a6b37af0871\PhpParser\Node\Param(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($argumentName), \_PhpScoper0a6b37af0871\PhpParser\BuilderHelpers::normalizeValue($defaultValue));
        if ($type) {
            $param->type = \ctype_upper($type[0]) ? new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($type) : new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier($type);
        }
        $classMethod->params[$position] = $param;
    }
    private function processStaticCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall, int $position, \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder $argumentAdder) : void
    {
        $argumentName = $argumentAdder->getArgumentName();
        if ($argumentName === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        if (!$staticCall->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
            return;
        }
        if (!$this->isName($staticCall->class, 'parent')) {
            return;
        }
        $staticCall->args[$position] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($argumentName));
    }
    /**
     * @param ClassMethod|MethodCall|StaticCall $node
     */
    private function isInCorrectScope(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentAdder $argumentAdder) : bool
    {
        if ($argumentAdder->getScope() === null) {
            return \true;
        }
        $scope = $argumentAdder->getScope();
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
            return $scope === self::SCOPE_CLASS_METHOD;
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            if (!$node->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
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
