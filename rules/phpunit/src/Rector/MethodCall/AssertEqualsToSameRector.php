<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\AssertEqualsToSameRector\AssertEqualsToSameRectorTest
 */
final class AssertEqualsToSameRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractPHPUnitRector
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
    private const SCALAR_TYPES = [\_PhpScoperb75b35f52b74\PHPStan\Type\FloatType::class, \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType::class, \_PhpScoperb75b35f52b74\PHPStan\Type\StringType::class];
    /**
     * @var IdentifierManipulator
     */
    private $identifierManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator $identifierManipulator)
    {
        $this->identifierManipulator = $identifierManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns `assertEquals()` into stricter `assertSame()` for scalar values in PHPUnit TestCase', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertEquals(2, $result, "message");', '$this->assertSame(2, $result, "message");'), new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertEquals($aString, $result, "message");', '$this->assertSame($aString, $result, "message");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
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
    private function getNodeType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var Scope $nodeScope */
        $nodeScope = $expr->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        return $nodeScope->getType($expr);
    }
    /**
     * @param string[] $types
     */
    private function isTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $valueType, array $types) : bool
    {
        foreach ($types as $type) {
            if (\is_a($valueType, $type, \true)) {
                return \true;
            }
        }
        return \false;
    }
}
