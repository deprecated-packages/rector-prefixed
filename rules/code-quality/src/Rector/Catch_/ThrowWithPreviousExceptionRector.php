<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Rector\Catch_;

use RectorPrefix20210106\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\Throw_;
use PhpParser\NodeTraverser;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Throwable;
/**
 * @see https://github.com/thecodingmachine/phpstan-strict-rules/blob/e3d746a61d38993ca2bc2e2fcda7012150de120c/src/Rules/Exceptions/ThrowMustBundlePreviousExceptionRule.php#L83
 * @see \Rector\CodeQuality\Tests\Rector\Catch_\ThrowWithPreviousExceptionRector\ThrowWithPreviousExceptionRectorTest
 */
final class ThrowWithPreviousExceptionRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var int
     */
    private const DEFAULT_EXCEPTION_ARGUMENT_POSITION = 2;
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('When throwing into a catch block, checks that the previous exception is passed to the new throw clause', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        try {
            $someCode = 1;
        } catch (Throwable $throwable) {
            throw new AnotherException('ups');
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        try {
            $someCode = 1;
        } catch (Throwable $throwable) {
            throw new AnotherException('ups', $throwable->getCode(), $throwable);
        }
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Catch_::class];
    }
    /**
     * @param Catch_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $caughtThrowableVariable = $node->var;
        if ($caughtThrowableVariable === null) {
            return null;
        }
        $this->traverseNodesWithCallable($node->stmts, function (\PhpParser\Node $node) use($caughtThrowableVariable) : ?int {
            if (!$node instanceof \PhpParser\Node\Stmt\Throw_) {
                return null;
            }
            return $this->refactorThrow($node, $caughtThrowableVariable);
        });
        return $node;
    }
    private function refactorThrow(\PhpParser\Node\Stmt\Throw_ $throw, \PhpParser\Node\Expr\Variable $catchedThrowableVariable) : ?int
    {
        if (!$throw->expr instanceof \PhpParser\Node\Expr\New_) {
            return null;
        }
        if (!$throw->expr->class instanceof \PhpParser\Node\Name) {
            return null;
        }
        $exceptionArgumentPosition = $this->resolveExceptionArgumentPosition($throw->expr->class);
        if ($exceptionArgumentPosition === null) {
            return null;
        }
        // exception is bundled
        if (isset($throw->expr->args[$exceptionArgumentPosition])) {
            return null;
        }
        if (!isset($throw->expr->args[1])) {
            // get previous code
            $throw->expr->args[1] = new \PhpParser\Node\Arg(new \PhpParser\Node\Expr\MethodCall($catchedThrowableVariable, 'getCode'));
        }
        $throw->expr->args[$exceptionArgumentPosition] = new \PhpParser\Node\Arg($catchedThrowableVariable);
        // nothing more to add
        return \PhpParser\NodeTraverser::STOP_TRAVERSAL;
    }
    private function resolveExceptionArgumentPosition(\PhpParser\Node\Name $exceptionName) : ?int
    {
        $fullyQualifiedName = $this->getName($exceptionName);
        // is native exception?
        if (!\RectorPrefix20210106\Nette\Utils\Strings::contains($fullyQualifiedName, '\\')) {
            return self::DEFAULT_EXCEPTION_ARGUMENT_POSITION;
        }
        // is class missing?
        if (!\class_exists($fullyQualifiedName)) {
            return self::DEFAULT_EXCEPTION_ARGUMENT_POSITION;
        }
        $reflectionClass = new \ReflectionClass($fullyQualifiedName);
        if (!$reflectionClass->hasMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return self::DEFAULT_EXCEPTION_ARGUMENT_POSITION;
        }
        /** @var ReflectionMethod $constructorReflectionMethod */
        $constructorReflectionMethod = $reflectionClass->getConstructor();
        foreach ($constructorReflectionMethod->getParameters() as $position => $reflectionParameter) {
            if (!$reflectionParameter->hasType()) {
                continue;
            }
            /** @var ReflectionNamedType $reflectionNamedType */
            $reflectionNamedType = $reflectionParameter->getType();
            if (!\is_a($reflectionNamedType->getName(), \Throwable::class, \true)) {
                continue;
            }
            return $position;
        }
        return null;
    }
}
