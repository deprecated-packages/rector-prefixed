<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\Php\TypeAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/sebastianbergmann/phpunit/blob/master/ChangeLog-8.0.md
 * @see https://github.com/sebastianbergmann/phpunit/commit/a406c85c51edd76ace29119179d8c21f590c939e
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\SpecificAssertInternalTypeRector\SpecificAssertInternalTypeRectorTest
 */
final class SpecificAssertInternalTypeRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var string[][]
     */
    private const TYPE_TO_METHOD = ['array' => ['assertIsArray', 'assertIsNotArray'], 'bool' => ['assertIsBool', 'assertIsNotBool'], 'float' => ['assertIsFloat', 'assertIsNotFloat'], 'int' => ['assertIsInt', 'assertIsNotInt'], 'numeric' => ['assertIsNumeric', 'assertIsNotNumeric'], 'object' => ['assertIsObject', 'assertIsNotObject'], 'resource' => ['assertIsResource', 'assertIsNotResource'], 'string' => ['assertIsString', 'assertIsNotString'], 'scalar' => ['assertIsScalar', 'assertIsNotScalar'], 'callable' => ['assertIsCallable', 'assertIsNotCallable'], 'iterable' => ['assertIsIterable', 'assertIsNotIterable'], 'null' => ['assertNull', 'assertNotNull']];
    /**
     * @var TypeAnalyzer
     */
    private $typeAnalyzer;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\Php\TypeAnalyzer $typeAnalyzer)
    {
        $this->typeAnalyzer = $typeAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change assertInternalType()/assertNotInternalType() method to new specific alternatives', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeTest extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $value = 'value';
        $this->assertInternalType('string', $value);
        $this->assertNotInternalType('array', $value);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeTest extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $value = 'value';
        $this->assertIsString($value);
        $this->assertIsNotArray($value);
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isPHPUnitMethodNames($node, ['assertInternalType', 'assertNotInternalType'])) {
            return null;
        }
        $typeNode = $node->args[0]->value;
        if (!$typeNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            return null;
        }
        $type = $this->typeAnalyzer->normalizeType($typeNode->value);
        if (!isset(self::TYPE_TO_METHOD[$type])) {
            return null;
        }
        \array_shift($node->args);
        $position = $this->isName($node->name, 'assertInternalType') ? 0 : 1;
        $methodName = self::TYPE_TO_METHOD[$type][$position];
        $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier($methodName);
        return $node;
    }
}
