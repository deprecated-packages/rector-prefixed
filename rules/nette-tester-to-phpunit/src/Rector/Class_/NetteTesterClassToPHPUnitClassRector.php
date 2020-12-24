<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteTesterToPHPUnit\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Include_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\NetteTesterToPHPUnit\Tests\Rector\Class_\NetteTesterClassToPHPUnitClassRector\NetteTesterPHPUnitRectorTest
 */
final class NetteTesterClassToPHPUnitClassRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Migrate Nette Tester test case to PHPUnit', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Include_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param Class_|Include_|MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Include_) {
            $this->processAboveTestInclude($node);
            return null;
        }
        if (!$this->isObjectType($node, '_PhpScopere8e811afab72\\Tester\\TestCase')) {
            return null;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            $this->processUnderTestRun($node);
            return null;
        }
        $this->processExtends($node);
        $this->processMethods($node);
        return $node;
    }
    private function processAboveTestInclude(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Include_ $include) : void
    {
        $classLike = $include->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            $this->removeNode($include);
        }
    }
    private function processUnderTestRun(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        if ($this->isName($methodCall->name, 'run')) {
            $this->removeNode($methodCall);
        }
    }
    private function processExtends(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $class->extends = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase');
    }
    private function processMethods(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        foreach ($class->getMethods() as $classMethod) {
            if ($this->isNames($classMethod, [\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::SET_UP, \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::TEAR_DOWN])) {
                $this->makeProtected($classMethod);
            }
        }
    }
}
