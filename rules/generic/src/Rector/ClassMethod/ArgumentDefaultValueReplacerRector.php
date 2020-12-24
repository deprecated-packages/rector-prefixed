<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\BuilderHelpers;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\ClassMethod\ArgumentDefaultValueReplacerRector\ArgumentDefaultValueReplacerRectorTest
 */
final class ArgumentDefaultValueReplacerRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const REPLACED_ARGUMENTS = 'replaced_arguments';
    /**
     * @var ArgumentDefaultValueReplacer[]
     */
    private $replacedArguments = [];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces defined map of arguments in defined methods and their calls.', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$someObject = new SomeClass;
$someObject->someMethod(SomeClass::OLD_CONSTANT);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someObject = new SomeClass;
$someObject->someMethod(false);'
CODE_SAMPLE
, [self::REPLACED_ARGUMENTS => [new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer('SomeExampleClass', 'someMethod', 0, 'SomeClass::OLD_CONSTANT', 'false')]])]);
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
        \_PhpScoper0a6b37af0871\Webmozart\Assert\Assert::allIsInstanceOf($replacedArguments, \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer::class);
        $this->replacedArguments = $replacedArguments;
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    private function processReplaces(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer $argumentDefaultValueReplacer) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
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
    private function processArgs(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer $argumentDefaultValueReplacer) : void
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
    private function normalizeValueToArgument($value) : \_PhpScoper0a6b37af0871\PhpParser\Node\Arg
    {
        // class constants → turn string to composite
        if (\is_string($value) && \_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($value, '::')) {
            [$class, $constant] = \explode('::', $value);
            $classConstFetch = $this->createClassConstFetch($class, $constant);
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($classConstFetch);
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg(\_PhpScoper0a6b37af0871\PhpParser\BuilderHelpers::normalizeValue($value));
    }
    /**
     * @param Arg[] $argumentNodes
     * @return Arg[]|null
     */
    private function processArrayReplacement(array $argumentNodes, \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer $argumentDefaultValueReplacer) : ?array
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
    private function resolveArgumentValuesToBeforeRecipe(array $argumentNodes, \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ArgumentDefaultValueReplacer $argumentDefaultValueReplacer) : array
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
