<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\Catch_;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Catch_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Throw_;
use _PhpScoper0a2ac50786fa\PhpParser\NodeTraverser;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Throwable;
/**
 * @see https://github.com/thecodingmachine/phpstan-strict-rules/blob/e3d746a61d38993ca2bc2e2fcda7012150de120c/src/Rules/Exceptions/ThrowMustBundlePreviousExceptionRule.php#L83
 * @see \Rector\CodeQuality\Tests\Rector\Catch_\ThrowWithPreviousExceptionRector\ThrowWithPreviousExceptionRectorTest
 */
final class ThrowWithPreviousExceptionRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var int
     */
    private const DEFAULT_EXCEPTION_ARGUMENT_POSITION = 2;
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('When throwing into a catch block, checks that the previous exception is passed to the new throw clause', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Catch_::class];
    }
    /**
     * @param Catch_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $caughtThrowableVariable = $node->var;
        if ($caughtThrowableVariable === null) {
            return null;
        }
        $this->traverseNodesWithCallable($node->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($caughtThrowableVariable) : ?int {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Throw_) {
                return null;
            }
            return $this->refactorThrow($node, $caughtThrowableVariable);
        });
        return $node;
    }
    private function refactorThrow(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Throw_ $throw, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $catchedThrowableVariable) : ?int
    {
        if (!$throw->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_) {
            return null;
        }
        if (!$throw->expr->class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
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
            $throw->expr->args[1] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($catchedThrowableVariable, 'getCode'));
        }
        $throw->expr->args[$exceptionArgumentPosition] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($catchedThrowableVariable);
        // nothing more to add
        return \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser::STOP_TRAVERSAL;
    }
    private function resolveExceptionArgumentPosition(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $exceptionName) : ?int
    {
        $fullyQualifiedName = $this->getName($exceptionName);
        // is native exception?
        if (!\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::contains($fullyQualifiedName, '\\')) {
            return self::DEFAULT_EXCEPTION_ARGUMENT_POSITION;
        }
        // is class missing?
        if (!\class_exists($fullyQualifiedName)) {
            return self::DEFAULT_EXCEPTION_ARGUMENT_POSITION;
        }
        $reflectionClass = new \ReflectionClass($fullyQualifiedName);
        if (!$reflectionClass->hasMethod(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
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
