<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception;

use LogicException;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompilerContext;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
use function assert;
use function get_class;
use function sprintf;
class UnableToCompileNode extends \LogicException
{
    /** @var string|null */
    private $constantName;
    public function constantName() : ?string
    {
        return $this->constantName;
    }
    public static function forUnRecognizedExpressionInContext(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expression, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompilerContext $context) : self
    {
        return new self(\sprintf('Unable to compile expression in %s: unrecognized node type %s at line %d', self::compilerContextToContextDescription($context), \get_class($expression), $expression->getLine()));
    }
    public static function becauseOfNotFoundClassConstantReference(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompilerContext $fetchContext, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $targetClass, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch $constantFetch) : self
    {
        \assert($constantFetch->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier);
        return new self(\sprintf('Could not locate constant %s::%s while trying to evaluate constant expression in %s at line %s', $targetClass->getName(), $constantFetch->name->name, self::compilerContextToContextDescription($fetchContext), $constantFetch->getLine()));
    }
    public static function becauseOfNotFoundConstantReference(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompilerContext $fetchContext, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch $constantFetch) : self
    {
        $constantName = $constantFetch->name->toString();
        $exception = new self(\sprintf('Could not locate constant "%s" while evaluating expression in %s at line %s', $constantName, self::compilerContextToContextDescription($fetchContext), $constantFetch->getLine()));
        $exception->constantName = $constantName;
        return $exception;
    }
    private static function compilerContextToContextDescription(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompilerContext $fetchContext) : string
    {
        // @todo improve in https://github.com/Roave/BetterReflection/issues/434
        return $fetchContext->hasSelf() ? $fetchContext->getSelf()->getName() : 'unknown context (probably a function)';
    }
}