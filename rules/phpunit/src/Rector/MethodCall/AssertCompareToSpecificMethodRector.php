<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\FunctionNameWithAssertMethods;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\AssertCompareToSpecificMethodRector\AssertCompareToSpecificMethodRectorTest
 */
final class AssertCompareToSpecificMethodRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var string
     */
    private const ASSERT_COUNT = 'assertCount';
    /**
     * @var string
     */
    private const ASSERT_NOT_COUNT = 'assertNotCount';
    /**
     * @var FunctionNameWithAssertMethods[]
     */
    private $functionNamesWithAssertMethods = [];
    public function __construct()
    {
        $this->functionNamesWithAssertMethods = [new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\FunctionNameWithAssertMethods('count', self::ASSERT_COUNT, self::ASSERT_NOT_COUNT), new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\FunctionNameWithAssertMethods('sizeof', self::ASSERT_COUNT, self::ASSERT_NOT_COUNT), new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\FunctionNameWithAssertMethods('iterator_count', self::ASSERT_COUNT, self::ASSERT_NOT_COUNT), new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\FunctionNameWithAssertMethods('gettype', 'assertInternalType', 'assertNotInternalType'), new \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\FunctionNameWithAssertMethods('get_class', 'assertInstanceOf', 'assertNotInstanceOf')];
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns vague php-only method in PHPUnit TestCase to more specific', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertSame(10, count($anything), "message");', '$this->assertCount(10, $anything, "message");'), new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertNotEquals(get_class($value), stdClass::class);', '$this->assertNotInstanceOf(stdClass::class, $value);')]);
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
        if (!$this->isPHPUnitMethodNames($node, ['assertSame', 'assertNotSame', 'assertEquals', 'assertNotEquals'])) {
            return null;
        }
        // we need 2 args
        if (!isset($node->args[1])) {
            return null;
        }
        $firstArgument = $node->args[0];
        $secondArgument = $node->args[1];
        $firstArgumentValue = $firstArgument->value;
        $secondArgumentValue = $secondArgument->value;
        if ($secondArgumentValue instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            return $this->processFuncCallArgumentValue($node, $secondArgumentValue, $firstArgument);
        }
        if ($firstArgumentValue instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            return $this->processFuncCallArgumentValue($node, $firstArgumentValue, $secondArgument);
        }
        return null;
    }
    /**
     * @param MethodCall|StaticCall $node
     * @return MethodCall|StaticCall|null
     */
    private function processFuncCallArgumentValue(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a6b37af0871\PhpParser\Node\Arg $requiredArg) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        foreach ($this->functionNamesWithAssertMethods as $functionNameWithAssertMethods) {
            if (!$this->isName($funcCall, $functionNameWithAssertMethods->getFunctionName())) {
                continue;
            }
            $this->renameMethod($node, $functionNameWithAssertMethods);
            $this->moveFunctionArgumentsUp($node, $funcCall, $requiredArg);
            return $node;
        }
        return null;
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function renameMethod(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\Rector\PHPUnit\ValueObject\FunctionNameWithAssertMethods $functionNameWithAssertMethods) : void
    {
        if ($this->isNames($node->name, ['assertSame', 'assertEquals'])) {
            $node->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier($functionNameWithAssertMethods->getAssetMethodName());
        } elseif ($this->isNames($node->name, ['assertNotSame', 'assertNotEquals'])) {
            $node->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier($functionNameWithAssertMethods->getNotAssertMethodName());
        }
    }
    /**
     * Handles custom error messages to not be overwrite by function with multiple args.
     * @param StaticCall|MethodCall $node
     */
    private function moveFunctionArgumentsUp(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a6b37af0871\PhpParser\Node\Arg $requiredArg) : void
    {
        $node->args[1] = $funcCall->args[0];
        $node->args[0] = $requiredArg;
    }
}
