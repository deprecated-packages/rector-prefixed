<?php

declare (strict_types=1);
namespace Rector\Removing\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Removing\ValueObject\ArgumentRemover;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210203\Webmozart\Assert\Assert;
/**
 * @see \Rector\Removing\Tests\Rector\ClassMethod\ArgumentRemoverRector\ArgumentRemoverRectorTest
 */
final class ArgumentRemoverRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const REMOVED_ARGUMENTS = 'removed_arguments';
    /**
     * @var ArgumentRemover[]
     */
    private $removedArguments = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes defined arguments in defined methods and their calls.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$someObject = new SomeClass;
$someObject->someMethod(true);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someObject = new SomeClass;
$someObject->someMethod();'
CODE_SAMPLE
, [self::REMOVED_ARGUMENTS => [new \Rector\Removing\ValueObject\ArgumentRemover('ExampleClass', 'someMethod', 0, 'true')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Expr\StaticCall::class, \PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->removedArguments as $removedArgument) {
            if (!$this->isMethodStaticCallOrClassMethodObjectType($node, $removedArgument->getClass())) {
                continue;
            }
            if (!$this->isName($node->name, $removedArgument->getMethod())) {
                continue;
            }
            $this->processPosition($node, $removedArgument);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $removedArguments = $configuration[self::REMOVED_ARGUMENTS] ?? [];
        \RectorPrefix20210203\Webmozart\Assert\Assert::allIsInstanceOf($removedArguments, \Rector\Removing\ValueObject\ArgumentRemover::class);
        $this->removedArguments = $removedArguments;
    }
    /**
     * @param ClassMethod|StaticCall|MethodCall $node
     */
    private function processPosition(\PhpParser\Node $node, \Rector\Removing\ValueObject\ArgumentRemover $argumentRemover) : void
    {
        if ($argumentRemover->getValue() === null) {
            if ($node instanceof \PhpParser\Node\Expr\MethodCall || $node instanceof \PhpParser\Node\Expr\StaticCall) {
                unset($node->args[$argumentRemover->getPosition()]);
            } else {
                unset($node->params[$argumentRemover->getPosition()]);
            }
            return;
        }
        $match = $argumentRemover->getValue();
        if (isset($match['name'])) {
            $this->removeByName($node, $argumentRemover->getPosition(), $match['name']);
            return;
        }
        // only argument specific value can be removed
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return;
        }
        if (!isset($node->args[$argumentRemover->getPosition()])) {
            return;
        }
        if ($this->isArgumentValueMatch($node->args[$argumentRemover->getPosition()], $match)) {
            unset($node->args[$argumentRemover->getPosition()]);
        }
    }
    /**
     * @param ClassMethod|StaticCall|MethodCall $node
     */
    private function removeByName(\PhpParser\Node $node, int $position, string $name) : void
    {
        if ($node instanceof \PhpParser\Node\Expr\MethodCall || $node instanceof \PhpParser\Node\Expr\StaticCall) {
            if (isset($node->args[$position]) && $this->isName($node->args[$position], $name)) {
                $this->removeArg($node, $position);
            }
            return;
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            if (isset($node->params[$position]) && $this->isName($node->params[$position], $name)) {
                $this->removeParam($node, $position);
            }
            return;
        }
    }
    /**
     * @param mixed[] $values
     */
    private function isArgumentValueMatch(\PhpParser\Node\Arg $arg, array $values) : bool
    {
        $nodeValue = $this->valueResolver->getValue($arg->value);
        return \in_array($nodeValue, $values, \true);
    }
}
