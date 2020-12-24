<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Laravel\Rector\StaticCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Mul;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Laravel\ValueObject\TypeToTimeMethodAndPosition;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/laravel/framework/pull/27276
 * @see https://laravel.com/docs/5.8/upgrade#cache-ttl-in-seconds
 *
 * @see \Rector\Laravel\Tests\Rector\StaticCall\MinutesToSecondsInCacheRector\MinutesToSecondsInCacheRectorTest
 */
final class MinutesToSecondsInCacheRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const ATTRIBUTE_KEY_ALREADY_MULTIPLIED = 'already_multiplied';
    /**
     * @var string
     */
    private const PUT = 'put';
    /**
     * @var string
     */
    private const ADD = 'add';
    /**
     * @var string
     */
    private const REMEMBER = 'remember';
    /**
     * @var TypeToTimeMethodAndPosition[]
     */
    private $typeToTimeMethodsAndPositions = [];
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector)
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->typeToTimeMethodsAndPositions = [new \_PhpScopere8e811afab72\Rector\Laravel\ValueObject\TypeToTimeMethodAndPosition('_PhpScopere8e811afab72\\Illuminate\\Support\\Facades\\Cache', self::PUT, 2), new \_PhpScopere8e811afab72\Rector\Laravel\ValueObject\TypeToTimeMethodAndPosition('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Cache\\Repository', self::PUT, 2), new \_PhpScopere8e811afab72\Rector\Laravel\ValueObject\TypeToTimeMethodAndPosition('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Cache\\Store', self::PUT, 2), new \_PhpScopere8e811afab72\Rector\Laravel\ValueObject\TypeToTimeMethodAndPosition('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Cache\\Repository', self::ADD, 2), new \_PhpScopere8e811afab72\Rector\Laravel\ValueObject\TypeToTimeMethodAndPosition('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Cache\\Store', self::ADD, 2), new \_PhpScopere8e811afab72\Rector\Laravel\ValueObject\TypeToTimeMethodAndPosition('_PhpScopere8e811afab72\\Illuminate\\Support\\Facades\\Cache', self::ADD, 2), new \_PhpScopere8e811afab72\Rector\Laravel\ValueObject\TypeToTimeMethodAndPosition('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Cache\\Repository', self::REMEMBER, 2), new \_PhpScopere8e811afab72\Rector\Laravel\ValueObject\TypeToTimeMethodAndPosition('_PhpScopere8e811afab72\\Illuminate\\Support\\Facades\\Cache', self::REMEMBER, 2), new \_PhpScopere8e811afab72\Rector\Laravel\ValueObject\TypeToTimeMethodAndPosition('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Cache\\Store', self::REMEMBER, 2), new \_PhpScopere8e811afab72\Rector\Laravel\ValueObject\TypeToTimeMethodAndPosition('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Cache\\Store', 'putMany', 1)];
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('_PhpScopere8e811afab72\\Change minutes argument to seconds in Illuminate\\Contracts\\Cache\\Store and Illuminate\\Support\\Facades\\Cache', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        Illuminate\Support\Facades\Cache::put('key', 'value', 60);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        Illuminate\Support\Facades\Cache::put('key', 'value', 60 * 60);
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param StaticCall|MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->typeToTimeMethodsAndPositions as $typeToTimeMethodAndPosition) {
            if (!$this->isObjectType($node, $typeToTimeMethodAndPosition->getType())) {
                continue;
            }
            if (!$this->isName($node->name, $typeToTimeMethodAndPosition->getMethodName())) {
                continue;
            }
            if (!isset($node->args[$typeToTimeMethodAndPosition->getPosition()])) {
                continue;
            }
            $argValue = $node->args[$typeToTimeMethodAndPosition->getPosition()]->value;
            return $this->processArgumentOnPosition($node, $argValue, $typeToTimeMethodAndPosition->getPosition());
        }
        return $node;
    }
    /**
     * @param StaticCall|MethodCall $node
     * @return StaticCall|MethodCall|null
     */
    private function processArgumentOnPosition(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PhpParser\Node\Expr $argExpr, int $argumentPosition) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($argExpr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch) {
            $this->refactorClassConstFetch($argExpr);
            return null;
        }
        if (!$this->isNumberType($argExpr)) {
            return null;
        }
        $mul = $this->mulByNumber($argExpr, 60);
        $node->args[$argumentPosition] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($mul);
        return $node;
    }
    private function refactorClassConstFetch(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch $classConstFetch) : void
    {
        $classConst = $this->nodeRepository->findClassConstByClassConstFetch($classConstFetch);
        if ($classConst === null) {
            return;
        }
        $onlyConst = $classConst->consts[0];
        $alreadyMultiplied = (bool) $onlyConst->getAttribute(self::ATTRIBUTE_KEY_ALREADY_MULTIPLIED);
        if ($alreadyMultiplied) {
            return;
        }
        $onlyConst->value = $this->mulByNumber($onlyConst->value, 60);
        $onlyConst->setAttribute(self::ATTRIBUTE_KEY_ALREADY_MULTIPLIED, \true);
    }
    private function mulByNumber(\_PhpScopere8e811afab72\PhpParser\Node\Expr $argExpr, int $value) : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($this->isValue($argExpr, 1)) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber($value);
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Mul($argExpr, new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber($value));
    }
}
