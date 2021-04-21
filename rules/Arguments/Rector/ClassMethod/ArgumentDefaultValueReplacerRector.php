<?php

declare(strict_types=1);

namespace Rector\Arguments\Rector\ClassMethod;

use Nette\Utils\Strings;
use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Arguments\ValueObject\ArgumentDefaultValueReplacer;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Webmozart\Assert\Assert;

/**
 * @see \Rector\Tests\Arguments\Rector\ClassMethod\ArgumentDefaultValueReplacerRector\ArgumentDefaultValueReplacerRectorTest
 */
final class ArgumentDefaultValueReplacerRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var string
     */
    const REPLACED_ARGUMENTS = 'replaced_arguments';

    /**
     * @var ArgumentDefaultValueReplacer[]
     */
    private $replacedArguments = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Replaces defined map of arguments in defined methods and their calls.',
            [
                new ConfiguredCodeSample(
                    <<<'CODE_SAMPLE'
$someObject = new SomeClass;
$someObject->someMethod(SomeClass::OLD_CONSTANT);
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
$someObject = new SomeClass;
$someObject->someMethod(false);'
CODE_SAMPLE
                    ,
                    [
                        self::REPLACED_ARGUMENTS => [
                            new ArgumentDefaultValueReplacer(
                                'SomeExampleClass',
                                'someMethod',
                                0,
                                'SomeClass::OLD_CONSTANT',
                                'false'
                            ),
                        ],
                    ]
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [MethodCall::class, StaticCall::class, ClassMethod::class];
    }

    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        foreach ($this->replacedArguments as $replacedArgument) {
            if (! $this->nodeTypeResolver->isMethodStaticCallOrClassMethodObjectType(
                $node,
                $replacedArgument->getObjectType()
            )) {
                continue;
            }

            if (! $this->isName($node->name, $replacedArgument->getMethod())) {
                continue;
            }

            $this->processReplaces($node, $replacedArgument);
        }

        return $node;
    }

    /**
     * @return void
     */
    public function configure(array $configuration)
    {
        $replacedArguments = $configuration[self::REPLACED_ARGUMENTS] ?? [];
        Assert::allIsInstanceOf($replacedArguments, ArgumentDefaultValueReplacer::class);
        $this->replacedArguments = $replacedArguments;
    }

    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     * @return \PhpParser\Node|null
     */
    private function processReplaces(Node $node, ArgumentDefaultValueReplacer $argumentDefaultValueReplacer)
    {
        if ($node instanceof ClassMethod) {
            if (! isset($node->params[$argumentDefaultValueReplacer->getPosition()])) {
                return null;
            }
        } elseif (isset($node->args[$argumentDefaultValueReplacer->getPosition()])) {
            $this->processArgs($node, $argumentDefaultValueReplacer);
        }

        return $node;
    }

    /**
     * @param MethodCall|StaticCall $expr
     * @return void
     */
    private function processArgs(Expr $expr, ArgumentDefaultValueReplacer $argumentDefaultValueReplacer)
    {
        $position = $argumentDefaultValueReplacer->getPosition();

        $argValue = $this->valueResolver->getValue($expr->args[$position]->value);

        if (is_scalar(
            $argumentDefaultValueReplacer->getValueBefore()
        ) && $argValue === $argumentDefaultValueReplacer->getValueBefore()) {
            $expr->args[$position] = $this->normalizeValueToArgument($argumentDefaultValueReplacer->getValueAfter());
        } elseif (is_array($argumentDefaultValueReplacer->getValueBefore())) {
            $newArgs = $this->processArrayReplacement($expr->args, $argumentDefaultValueReplacer);

            if ($newArgs) {
                $expr->args = $newArgs;
            }
        }
    }

    /**
     * @param mixed $value
     */
    private function normalizeValueToArgument($value): Arg
    {
        // class constants → turn string to composite
        if (is_string($value) && Strings::contains($value, '::')) {
            list($class, $constant) = explode('::', $value);
            $classConstFetch = $this->nodeFactory->createClassConstFetch($class, $constant);

            return new Arg($classConstFetch);
        }

        return new Arg(BuilderHelpers::normalizeValue($value));
    }

    /**
     * @param Arg[] $argumentNodes
     * @return mixed[]|null
     */
    private function processArrayReplacement(
        array $argumentNodes,
        ArgumentDefaultValueReplacer $argumentDefaultValueReplacer
    ) {
        $argumentValues = $this->resolveArgumentValuesToBeforeRecipe($argumentNodes, $argumentDefaultValueReplacer);
        if ($argumentValues !== $argumentDefaultValueReplacer->getValueBefore()) {
            return null;
        }

        if (is_string($argumentDefaultValueReplacer->getValueAfter())) {
            $argumentNodes[$argumentDefaultValueReplacer->getPosition()] = $this->normalizeValueToArgument(
                $argumentDefaultValueReplacer->getValueAfter()
            );

            // clear following arguments
            $argumentCountToClear = count($argumentDefaultValueReplacer->getValueBefore());
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
    private function resolveArgumentValuesToBeforeRecipe(
        array $argumentNodes,
        ArgumentDefaultValueReplacer $argumentDefaultValueReplacer
    ): array {
        $argumentValues = [];

        /** @var mixed[] $valueBefore */
        $valueBefore = $argumentDefaultValueReplacer->getValueBefore();
        $beforeArgumentCount = count($valueBefore);

        for ($i = 0; $i < $beforeArgumentCount; ++$i) {
            if (! isset($argumentNodes[$argumentDefaultValueReplacer->getPosition() + $i])) {
                continue;
            }

            $nextArg = $argumentNodes[$argumentDefaultValueReplacer->getPosition() + $i];
            $argumentValues[] = $this->valueResolver->getValue($nextArg->value);
        }

        return $argumentValues;
    }
}
