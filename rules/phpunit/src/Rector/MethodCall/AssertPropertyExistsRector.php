<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\AssertPropertyExistsRector\AssertPropertyExistsRectorTest
 */
final class AssertPropertyExistsRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var array<string, string>
     */
    private const RENAME_METHODS_WITH_OBJECT_MAP = ['assertTrue' => 'assertObjectHasAttribute', 'assertFalse' => 'assertObjectNotHasAttribute'];
    /**
     * @var array<string, string>
     */
    private const RENAME_METHODS_WITH_CLASS_MAP = ['assertTrue' => 'assertClassHasAttribute', 'assertFalse' => 'assertClassNotHasAttribute'];
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
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns `property_exists` comparisons to their method name alternatives in PHPUnit TestCase', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertTrue(property_exists(new Class, "property"), "message");', '$this->assertClassHasAttribute("property", "Class", "message");'), new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertFalse(property_exists(new Class, "property"), "message");', '$this->assertClassNotHasAttribute("property", "Class", "message");')]);
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
        if (!$this->isPHPUnitMethodNames($node, ['assertTrue', 'assertFalse'])) {
            return null;
        }
        $firstArgumentValue = $node->args[0]->value;
        if ($firstArgumentValue instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall) {
            return null;
        }
        if (!$this->isName($firstArgumentValue, 'property_exists')) {
            return null;
        }
        $propertyExistsMethodCall = $node->args[0]->value;
        if (!$propertyExistsMethodCall instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall) {
            return null;
        }
        $firstArgument = $propertyExistsMethodCall->args[0];
        $secondArgument = $propertyExistsMethodCall->args[1];
        if ($firstArgument->value instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            $secondArg = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable($firstArgument->value->name);
            $map = self::RENAME_METHODS_WITH_OBJECT_MAP;
        } elseif ($firstArgument->value instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_) {
            $secondArg = $this->getName($firstArgument->value->class);
            $map = self::RENAME_METHODS_WITH_CLASS_MAP;
        } else {
            return null;
        }
        if (!$secondArgument->value instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            return null;
        }
        unset($node->args[0]);
        $newArgs = $this->createArgs([$secondArgument->value->value, $secondArg]);
        $node->args = $this->appendArgs($newArgs, $node->args);
        $this->identifierManipulator->renameNodeWithMap($node, $map);
        return $node;
    }
}
