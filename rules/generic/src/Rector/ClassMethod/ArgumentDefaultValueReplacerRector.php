<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\BuilderHelpers;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\ClassMethod\ArgumentDefaultValueReplacerRector\ArgumentDefaultValueReplacerRectorTest
 */
final class ArgumentDefaultValueReplacerRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const REPLACED_ARGUMENTS = 'replaced_arguments';
    /**
     * @var ArgumentDefaultValueReplacer[]
     */
    private $replacedArguments = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces defined map of arguments in defined methods and their calls.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$someObject = new SomeClass;
$someObject->someMethod(SomeClass::OLD_CONSTANT);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someObject = new SomeClass;
$someObject->someMethod(false);'
CODE_SAMPLE
, [self::REPLACED_ARGUMENTS => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('SomeExampleClass', 'someMethod', 0, 'SomeClass::OLD_CONSTANT', 'false')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->replacedArguments as $replacedArgument) {
            if (!$this->isMethodStaticCallOrClassMethodObjectType($node, $replacedArgument->getClass())) {
                continue;
            }
            if (!$this->isName($node->name, $replacedArgument->getMethod())) {
                continue;
            }
            $this->processReplaces($node, $replacedArgument);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $replacedArguments = $configuration[self::REPLACED_ARGUMENTS] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($replacedArguments, \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer::class);
        $this->replacedArguments = $replacedArguments;
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    private function processReplaces(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer $argumentDefaultValueReplacer) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            if (!isset($node->params[$argumentDefaultValueReplacer->getPosition()])) {
                return null;
            }
        } elseif (isset($node->args[$argumentDefaultValueReplacer->getPosition()])) {
            $this->processArgs($node, $argumentDefaultValueReplacer);
        }
        return $node;
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function processArgs(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer $argumentDefaultValueReplacer) : void
    {
        $position = $argumentDefaultValueReplacer->getPosition();
        $argValue = $this->getValue($node->args[$position]->value);
        if (\is_scalar($argumentDefaultValueReplacer->getValueBefore()) && $argValue === $argumentDefaultValueReplacer->getValueBefore()) {
            $node->args[$position] = $this->normalizeValueToArgument($argumentDefaultValueReplacer->getValueAfter());
        } elseif (\is_array($argumentDefaultValueReplacer->getValueBefore())) {
            $newArgs = $this->processArrayReplacement($node->args, $argumentDefaultValueReplacer);
            if ($newArgs) {
                $node->args = $newArgs;
            }
        }
    }
    /**
     * @param mixed $value
     */
    private function normalizeValueToArgument($value) : \_PhpScopere8e811afab72\PhpParser\Node\Arg
    {
        // class constants → turn string to composite
        if (\is_string($value) && \_PhpScopere8e811afab72\Nette\Utils\Strings::contains($value, '::')) {
            [$class, $constant] = \explode('::', $value);
            $classConstFetch = $this->createClassConstFetch($class, $constant);
            return new \_PhpScopere8e811afab72\PhpParser\Node\Arg($classConstFetch);
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Arg(\_PhpScopere8e811afab72\PhpParser\BuilderHelpers::normalizeValue($value));
    }
    /**
     * @param Arg[] $argumentNodes
     * @return Arg[]|null
     */
    private function processArrayReplacement(array $argumentNodes, \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer $argumentDefaultValueReplacer) : ?array
    {
        $argumentValues = $this->resolveArgumentValuesToBeforeRecipe($argumentNodes, $argumentDefaultValueReplacer);
        if ($argumentValues !== $argumentDefaultValueReplacer->getValueBefore()) {
            return null;
        }
        if (\is_string($argumentDefaultValueReplacer->getValueAfter())) {
            $argumentNodes[$argumentDefaultValueReplacer->getPosition()] = $this->normalizeValueToArgument($argumentDefaultValueReplacer->getValueAfter());
            // clear following arguments
            $argumentCountToClear = \count($argumentDefaultValueReplacer->getValueBefore());
            for ($i = $argumentDefaultValueReplacer->getPosition() + 1; $i <= $argumentDefaultValueReplacer->getPosition() + $argumentCountToClear; ++$i) {
                unset($argumentNodes[$i]);
            }
        }
        return $argumentNodes;
    }
    /**
     * @param Arg[] $argumentNodes
     * @return mixed[]
     */
    private function resolveArgumentValuesToBeforeRecipe(array $argumentNodes, \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer $argumentDefaultValueReplacer) : array
    {
        $argumentValues = [];
        /** @var mixed[] $valueBefore */
        $valueBefore = $argumentDefaultValueReplacer->getValueBefore();
        $beforeArgumentCount = \count($valueBefore);
        for ($i = 0; $i < $beforeArgumentCount; ++$i) {
            if (!isset($argumentNodes[$argumentDefaultValueReplacer->getPosition() + $i])) {
                continue;
            }
            $nextArg = $argumentNodes[$argumentDefaultValueReplacer->getPosition() + $i];
            $argumentValues[] = $this->getValue($nextArg->value);
        }
        return $argumentValues;
    }
}
