<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\AssertTrueFalseInternalTypeToSpecificMethodRector\AssertTrueFalseInternalTypeToSpecificMethodRectorTest
 */
final class AssertTrueFalseInternalTypeToSpecificMethodRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var array<string, string>
     */
    private const OLD_FUNCTIONS_TO_TYPES = ['is_array' => 'array', 'is_bool' => 'bool', 'is_callable' => 'callable', 'is_double' => 'double', 'is_float' => 'float', 'is_int' => 'int', 'is_integer' => 'integer', 'is_iterable' => 'iterable', 'is_numeric' => 'numeric', 'is_object' => 'object', 'is_real' => 'real', 'is_resource' => 'resource', 'is_scalar' => 'scalar', 'is_string' => 'string'];
    /**
     * @var array<string, string>
     */
    private const RENAME_METHODS_MAP = ['assertTrue' => 'assertInternalType', 'assertFalse' => 'assertNotInternalType'];
    /**
     * @var IdentifierManipulator
     */
    private $identifierManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator $identifierManipulator)
    {
        $this->identifierManipulator = $identifierManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns true/false with internal type comparisons to their method name alternatives in PHPUnit TestCase', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertTrue(is_{internal_type}($anything), "message");', '$this->assertInternalType({internal_type}, $anything, "message");'), new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertFalse(is_{internal_type}($anything), "message");', '$this->assertNotInternalType({internal_type}, $anything, "message");')]);
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
        $oldMethods = \array_keys(self::RENAME_METHODS_MAP);
        if (!$this->isPHPUnitMethodNames($node, $oldMethods)) {
            return null;
        }
        /** @var FuncCall|Node $firstArgumentValue */
        $firstArgumentValue = $node->args[0]->value;
        if (!$firstArgumentValue instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            return null;
        }
        $functionName = $this->getName($firstArgumentValue);
        if (!isset(self::OLD_FUNCTIONS_TO_TYPES[$functionName])) {
            return null;
        }
        $this->identifierManipulator->renameNodeWithMap($node, self::RENAME_METHODS_MAP);
        return $this->moveFunctionArgumentsUp($node);
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function moveFunctionArgumentsUp(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        /** @var FuncCall $isFunctionNode */
        $isFunctionNode = $node->args[0]->value;
        $firstArgumentValue = $isFunctionNode->args[0]->value;
        $isFunctionName = $this->getName($isFunctionNode);
        $newArgs = [new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg(new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_(self::OLD_FUNCTIONS_TO_TYPES[$isFunctionName])), new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($firstArgumentValue)];
        $oldArguments = $node->args;
        unset($oldArguments[0]);
        $node->args = $this->appendArgs($newArgs, $oldArguments);
        return $node;
    }
}
