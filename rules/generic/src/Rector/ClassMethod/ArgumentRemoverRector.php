<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\ClassMethod\ArgumentRemoverRector\ArgumentRemoverRectorTest
 */
final class ArgumentRemoverRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const REMOVED_ARGUMENTS = 'removed_arguments';
    /**
     * @var ArgumentRemover[]
     */
    private $removedArguments = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes defined arguments in defined methods and their calls.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$someObject = new SomeClass;
$someObject->someMethod(true);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someObject = new SomeClass;
$someObject->someMethod();'
CODE_SAMPLE
, [self::REMOVED_ARGUMENTS => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover('ExampleClass', 'someMethod', 0, 'true')]])]);
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
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($removedArguments, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover::class);
        $this->removedArguments = $removedArguments;
    }
    /**
     * @param ClassMethod|StaticCall|MethodCall $node
     */
    private function processPosition(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover $argumentRemover) : void
    {
        if ($argumentRemover->getValue() === null) {
            if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
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
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod || !isset($node->args[$argumentRemover->getPosition()])) {
            return;
        }
        if ($this->isArgumentValueMatch($node->args[$argumentRemover->getPosition()], $match)) {
            unset($node->args[$argumentRemover->getPosition()]);
        }
    }
    /**
     * @param ClassMethod|StaticCall|MethodCall $node
     */
    private function removeByName(\_PhpScoperb75b35f52b74\PhpParser\Node $node, int $position, string $name) : void
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            if (isset($node->args[$position]) && $this->isName($node->args[$position], $name)) {
                $this->removeArg($node, $position);
            }
            return;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            if (isset($node->params[$position]) && $this->isName($node->params[$position], $name)) {
                $this->removeParam($node, $position);
            }
            return;
        }
    }
    /**
     * @param mixed[] $values
     */
    private function isArgumentValueMatch(\_PhpScoperb75b35f52b74\PhpParser\Node\Arg $arg, array $values) : bool
    {
        $nodeValue = $this->getValue($arg->value);
        return \in_array($nodeValue, $values, \true);
    }
}
