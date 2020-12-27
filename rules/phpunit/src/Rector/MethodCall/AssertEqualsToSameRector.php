<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator;
use Rector\Core\Rector\AbstractPHPUnitRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\AssertEqualsToSameRector\AssertEqualsToSameRectorTest
 */
final class AssertEqualsToSameRector extends \Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var array<string, string>
     */
    private const RENAME_METHODS_MAP = ['assertEquals' => 'assertSame'];
    /**
     * We exclude
     * - bool because this is taken care of AssertEqualsParameterToSpecificMethodsTypeRector
     * - null because this is taken care of AssertEqualsParameterToSpecificMethodsTypeRector
     *
     * @var string[]
     */
    private const SCALAR_TYPES = [\PHPStan\Type\FloatType::class, \PHPStan\Type\IntegerType::class, \PHPStan\Type\StringType::class];
    /**
     * @var IdentifierManipulator
     */
    private $identifierManipulator;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator $identifierManipulator)
    {
        $this->identifierManipulator = $identifierManipulator;
    }
    public function getRuleDefinition() : \RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns `assertEquals()` into stricter `assertSame()` for scalar values in PHPUnit TestCase', [new \RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertEquals(2, $result, "message");', '$this->assertSame(2, $result, "message");'), new \RectorPrefix20201227\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertEquals($aString, $result, "message");', '$this->assertSame($aString, $result, "message");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isInTestClass($node)) {
            return null;
        }
        $methodNames = \array_keys(self::RENAME_METHODS_MAP);
        if (!$this->isNames($node->name, $methodNames)) {
            return null;
        }
        if (!isset($node->args[0])) {
            return null;
        }
        $valueNode = $node->args[0];
        $valueNodeType = $this->getNodeType($valueNode->value);
        if (!$this->isTypes($valueNodeType, self::SCALAR_TYPES)) {
            return null;
        }
        $this->identifierManipulator->renameNodeWithMap($node, self::RENAME_METHODS_MAP);
        return $node;
    }
    private function getNodeType(\PhpParser\Node\Expr $expr) : \PHPStan\Type\Type
    {
        /** @var Scope $nodeScope */
        $nodeScope = $expr->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        return $nodeScope->getType($expr);
    }
    /**
     * @param string[] $types
     */
    private function isTypes(\PHPStan\Type\Type $valueType, array $types) : bool
    {
        foreach ($types as $type) {
            if (\is_a($valueType, $type, \true)) {
                return \true;
            }
        }
        return \false;
    }
}
