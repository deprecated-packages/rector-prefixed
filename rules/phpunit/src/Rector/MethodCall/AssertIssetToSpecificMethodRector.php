<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Isset_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\AssertIssetToSpecificMethodRector\AssertIssetToSpecificMethodRectorTest
 */
final class AssertIssetToSpecificMethodRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var string
     */
    private const ASSERT_TRUE = 'assertTrue';
    /**
     * @var string
     */
    private const ASSERT_FALSE = 'assertFalse';
    /**
     * @var IdentifierManipulator
     */
    private $identifierManipulator;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator $identifierManipulator)
    {
        $this->identifierManipulator = $identifierManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns isset comparisons to their method name alternatives in PHPUnit TestCase', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertTrue(isset($anything->foo));', '$this->assertObjectHasAttribute("foo", $anything);'), new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertFalse(isset($anything["foo"]), "message");', '$this->assertArrayNotHasKey("foo", $anything, "message");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isPHPUnitMethodNames($node, [self::ASSERT_TRUE, self::ASSERT_FALSE])) {
            return null;
        }
        $firstArgumentValue = $node->args[0]->value;
        // is property access
        if (!$firstArgumentValue instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Isset_) {
            return null;
        }
        $variableNodeClass = \get_class($firstArgumentValue->vars[0]);
        if (!\in_array($variableNodeClass, [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch::class], \true)) {
            return null;
        }
        /** @var Isset_ $issetNode */
        $issetNode = $node->args[0]->value;
        $issetNodeArg = $issetNode->vars[0];
        if ($issetNodeArg instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch) {
            $this->refactorPropertyFetchNode($node, $issetNodeArg);
        } elseif ($issetNodeArg instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch) {
            $this->refactorArrayDimFetchNode($node, $issetNodeArg);
        }
        return $node;
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function refactorPropertyFetchNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : void
    {
        $name = $this->getName($propertyFetch);
        if ($name === null) {
            return;
        }
        $this->identifierManipulator->renameNodeWithMap($node, [self::ASSERT_TRUE => 'assertObjectHasAttribute', self::ASSERT_FALSE => 'assertObjectNotHasAttribute']);
        $oldArgs = $node->args;
        unset($oldArgs[0]);
        $newArgs = $this->createArgs([new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($name), $propertyFetch->var]);
        $node->args = $this->appendArgs($newArgs, $oldArgs);
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function refactorArrayDimFetchNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : void
    {
        $this->identifierManipulator->renameNodeWithMap($node, [self::ASSERT_TRUE => 'assertArrayHasKey', self::ASSERT_FALSE => 'assertArrayNotHasKey']);
        $oldArgs = $node->args;
        unset($oldArgs[0]);
        $node->args = \array_merge($this->createArgs([$arrayDimFetch->dim, $arrayDimFetch->var]), $oldArgs);
    }
}
