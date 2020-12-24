<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\DNumber;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\FloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Generic\NodeTypeAnalyzer\CallTypeAnalyzer;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Generic\Tests\Rector\MethodCall\FormerNullableArgumentToScalarTypedRector\FormerNullableArgumentToScalarTypedRectorTest
 */
final class FormerNullableArgumentToScalarTypedRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var CallTypeAnalyzer
     */
    private $callTypeAnalyzer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Generic\NodeTypeAnalyzer\CallTypeAnalyzer $callTypeAnalyzer)
    {
        $this->callTypeAnalyzer = $callTypeAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change null in argument, that is now not nullable anymore', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $this->setValue(null);
    }

    public function setValue(string $value)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $this->setValue('');
    }

    public function setValue(string $value)
    {
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node->args === []) {
            return null;
        }
        $methodParameterTypes = $this->callTypeAnalyzer->resolveMethodParameterTypes($node);
        if ($methodParameterTypes === []) {
            return null;
        }
        foreach ($node->args as $key => $arg) {
            if (!$this->isNull($arg->value)) {
                continue;
            }
            /** @var int $key */
            $this->refactorArg($arg, $methodParameterTypes, $key);
        }
        return $node;
    }
    /**
     * @param Type[] $methodParameterTypes
     */
    private function refactorArg(\_PhpScoper0a6b37af0871\PhpParser\Node\Arg $arg, array $methodParameterTypes, int $key) : void
    {
        if (!isset($methodParameterTypes[$key])) {
            return;
        }
        $parameterType = $methodParameterTypes[$key];
        if ($parameterType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StringType) {
            $arg->value = new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_('');
        }
        if ($parameterType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType) {
            $arg->value = new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber(0);
        }
        if ($parameterType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType) {
            $arg->value = new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\DNumber(0);
        }
        if ($parameterType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType) {
            $arg->value = $this->createFalse();
        }
    }
}
