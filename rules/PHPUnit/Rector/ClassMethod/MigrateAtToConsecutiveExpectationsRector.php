<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\Rector\AbstractRector;
use Rector\PHPUnit\NodeAnalyzer\ExpectationAnalyzer;
use Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer;
use Rector\PHPUnit\NodeFactory\ConsecutiveAssertionFactory;
use Rector\PHPUnit\ValueObject\ExpectationMock;
use Rector\PHPUnit\ValueObject\ExpectationMockCollection;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\PHPUnit\Rector\ClassMethod\MigrateAtToConsecutiveExpectationsRector\MigrateAtToConsecutiveExpectationsRectorTest
 */
final class MigrateAtToConsecutiveExpectationsRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ConsecutiveAssertionFactory
     */
    private $consecutiveAssertionFactory;
    /**
     * @var TestsNodeAnalyzer
     */
    private $testsNodeAnalyzer;
    /**
     * @var ExpectationAnalyzer
     */
    private $expectationAnalyzer;
    public function __construct(\Rector\PHPUnit\NodeFactory\ConsecutiveAssertionFactory $consecutiveAssertionFactory, \Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer $testsNodeAnalyzer, \Rector\PHPUnit\NodeAnalyzer\ExpectationAnalyzer $expectationAnalyzer)
    {
        $this->consecutiveAssertionFactory = $consecutiveAssertionFactory;
        $this->testsNodeAnalyzer = $testsNodeAnalyzer;
        $this->expectationAnalyzer = $expectationAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Migrates deprecated $this->at to $this->withConsecutive and $this->willReturnOnConsecutiveCalls', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$mock = $this->createMock(Foo::class);
$mock->expects($this->at(0))->with('0')->method('someMethod')->willReturn('1');
$mock->expects($this->at(1))->with('1')->method('someMethod')->willReturn('2');
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$mock = $this->createMock(Foo::class);
$mock->method('someMethod')->withConsecutive(['0'], ['1'])->willReturnOnConsecutiveCalls('1', '2');
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        $stmts = $node->stmts;
        if ($stmts === null) {
            return null;
        }
        $expressions = \array_filter($stmts, function (\PhpParser\Node\Stmt $expr) {
            return $expr instanceof \PhpParser\Node\Stmt\Expression && $expr->expr instanceof \PhpParser\Node\Expr\MethodCall;
        });
        $expectationMockCollection = $this->expectationAnalyzer->getExpectationsFromExpressions($expressions);
        if (!$expectationMockCollection->hasExpectationMocks()) {
            return null;
        }
        $expectationCollections = $this->groupExpectationCollectionsByVariableName($expectationMockCollection);
        foreach ($expectationCollections as $expectationCollection) {
            $this->replaceExpectationNodes($expectationCollection);
        }
        return $node;
    }
    /**
     * @param \Rector\PHPUnit\ValueObject\ExpectationMockCollection $expectationMockCollection
     */
    private function buildNewExpectation($expectationMockCollection) : \PhpParser\Node\Expr\MethodCall
    {
        $expectationMockCollection = $this->fillMissingAtIndexes($expectationMockCollection);
        return $this->consecutiveAssertionFactory->createAssertionFromExpectationMockCollection($expectationMockCollection);
    }
    /**
     * @param \Rector\PHPUnit\ValueObject\ExpectationMockCollection $expectationMockCollection
     */
    private function fillMissingAtIndexes($expectationMockCollection) : \Rector\PHPUnit\ValueObject\ExpectationMockCollection
    {
        $var = $expectationMockCollection->getExpectationMocks()[0]->getExpectationVariable();
        // 0,1,2,3,4
        // min = 0 ; max = 4 ; count = 5
        // OK
        // 1,2,3,4
        // min = 1 ; max = 4 ; count = 4
        // ADD 0
        // OR
        // 3
        // min = 3; max = 3 ; count = 1
        // 0,1,2
        if ($expectationMockCollection->getLowestAtIndex() !== 0) {
            for ($i = 0; $i < $expectationMockCollection->getLowestAtIndex(); ++$i) {
                $expectationMockCollection->add(new \Rector\PHPUnit\ValueObject\ExpectationMock($var, [], $i, null, [], null));
            }
        }
        // 0,1,2,4
        // min = 0 ; max = 4 ; count = 4
        // ADD 3
        if ($expectationMockCollection->isMissingAtIndexBetweenHighestAndLowest()) {
            $existingIndexes = \array_column($expectationMockCollection->getExpectationMocks(), 'index');
            for ($i = 1; $i < $expectationMockCollection->getHighestAtIndex(); ++$i) {
                if (!\in_array($i, $existingIndexes, \true)) {
                    $expectationMockCollection->add(new \Rector\PHPUnit\ValueObject\ExpectationMock($var, [], $i, null, [], null));
                }
            }
        }
        return $expectationMockCollection;
    }
    /**
     * @param \Rector\PHPUnit\ValueObject\ExpectationMockCollection $expectationMockCollection
     */
    private function replaceExpectationNodes($expectationMockCollection) : void
    {
        if ($this->shouldSkipReplacement($expectationMockCollection)) {
            return;
        }
        $endLines = \array_map(static function (\Rector\PHPUnit\ValueObject\ExpectationMock $expectationMock) {
            $originalExpression = $expectationMock->originalExpression();
            return $originalExpression === null ? 0 : $originalExpression->getEndLine();
        }, $expectationMockCollection->getExpectationMocks());
        $max = \max($endLines);
        foreach ($expectationMockCollection->getExpectationMocks() as $expectationMock) {
            $originalExpression = $expectationMock->originalExpression();
            if ($originalExpression === null) {
                continue;
            }
            if ($max > $originalExpression->getEndLine()) {
                $this->removeNode($originalExpression);
            } else {
                $originalExpression->expr = $this->buildNewExpectation($expectationMockCollection);
            }
        }
    }
    /**
     * @param \Rector\PHPUnit\ValueObject\ExpectationMockCollection $expectationMockCollection
     */
    private function shouldSkipReplacement($expectationMockCollection) : bool
    {
        if (!$expectationMockCollection->hasReturnValues()) {
            return \false;
        }
        if (!$expectationMockCollection->isExpectedMethodAlwaysTheSame()) {
            return \true;
        }
        if ($expectationMockCollection->hasMissingAtIndexes()) {
            return \true;
        }
        if ($expectationMockCollection->hasMissingReturnValues()) {
            return \true;
        }
        return \false;
    }
    /**
     * @return ExpectationMockCollection[]
     * @param \Rector\PHPUnit\ValueObject\ExpectationMockCollection $expectationMockCollection
     */
    private function groupExpectationCollectionsByVariableName($expectationMockCollection) : array
    {
        $groupedByVariable = [];
        foreach ($expectationMockCollection->getExpectationMocks() as $expectationMock) {
            $variable = $expectationMock->getExpectationVariable();
            if (!\is_string($variable->name)) {
                continue;
            }
            if (!isset($groupedByVariable[$variable->name])) {
                $groupedByVariable[$variable->name] = new \Rector\PHPUnit\ValueObject\ExpectationMockCollection();
            }
            $groupedByVariable[$variable->name]->add($expectationMock);
        }
        return \array_values($groupedByVariable);
    }
}