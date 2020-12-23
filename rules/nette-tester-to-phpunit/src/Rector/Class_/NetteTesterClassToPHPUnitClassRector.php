<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteTesterToPHPUnit\Rector\Class_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Include_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\NetteTesterToPHPUnit\Tests\Rector\Class_\NetteTesterClassToPHPUnitClassRector\NetteTesterPHPUnitRectorTest
 */
final class NetteTesterClassToPHPUnitClassRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Migrate Nette Tester test case to PHPUnit', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
namespace KdybyTests\Doctrine;

use Tester\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class ExtensionTest extends TestCase
{
    public function testFunctionality()
    {
        Assert::true($default instanceof Kdyby\Doctrine\EntityManager);
        Assert::true(5);
        Assert::same($container->getService('kdyby.doctrine.default.entityManager'), $default);
    }
}

(new \ExtensionTest())->run();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
namespace KdybyTests\Doctrine;

use Tester\TestCase;
use Tester\Assert;

class ExtensionTest extends \PHPUnit\Framework\TestCase
{
    public function testFunctionality()
    {
        $this->assertInstanceOf(\Kdyby\Doctrine\EntityManager::cllass, $default);
        $this->assertTrue(5);
        $this->same($container->getService('kdyby.doctrine.default.entityManager'), $default);
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Include_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param Class_|Include_|MethodCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Include_) {
            $this->processAboveTestInclude($node);
            return null;
        }
        if (!$this->isObjectType($node, '_PhpScoper0a2ac50786fa\\Tester\\TestCase')) {
            return null;
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            $this->processUnderTestRun($node);
            return null;
        }
        $this->processExtends($node);
        $this->processMethods($node);
        return $node;
    }
    private function processAboveTestInclude(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Include_ $include) : void
    {
        $classLike = $include->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            $this->removeNode($include);
        }
    }
    private function processUnderTestRun(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        if ($this->isName($methodCall->name, 'run')) {
            $this->removeNode($methodCall);
        }
    }
    private function processExtends(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $class->extends = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase');
    }
    private function processMethods(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : void
    {
        foreach ($class->getMethods() as $classMethod) {
            if ($this->isNames($classMethod, [\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::SET_UP, \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::TEAR_DOWN])) {
                $this->makeProtected($classMethod);
            }
        }
    }
}
