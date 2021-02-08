<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use Rector\Core\Rector\AbstractRector;
use Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer;
use Rector\Renaming\NodeManipulator\IdentifierManipulator;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\AssertFalseStrposToContainsRector\AssertFalseStrposToContainsRectorTest
 */
final class AssertFalseStrposToContainsRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var array<string, string>
     */
    private const RENAME_METHODS_MAP = ['assertFalse' => 'assertNotContains', 'assertNotFalse' => 'assertContains'];
    /**
     * @var IdentifierManipulator
     */
    private $identifierManipulator;
    /**
     * @var TestsNodeAnalyzer
     */
    private $testsNodeAnalyzer;
    public function __construct(\Rector\Renaming\NodeManipulator\IdentifierManipulator $identifierManipulator, \Rector\PHPUnit\NodeAnalyzer\TestsNodeAnalyzer $testsNodeAnalyzer)
    {
        $this->identifierManipulator = $identifierManipulator;
        $this->testsNodeAnalyzer = $testsNodeAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns `strpos`/`stripos` comparisons to their method name alternatives in PHPUnit TestCase', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertFalse(strpos($anything, "foo"), "message");', '$this->assertNotContains("foo", $anything, "message");'), new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->assertNotFalse(stripos($anything, "foo"), "message");', '$this->assertContains("foo", $anything, "message");')]);
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
        $oldMethodName = \array_keys(self::RENAME_METHODS_MAP);
        if (!$this->testsNodeAnalyzer->isPHPUnitMethodNames($node, $oldMethodName)) {
            return null;
        }
        $firstArgumentValue = $node->args[0]->value;
        if ($firstArgumentValue instanceof \PhpParser\Node\Expr\StaticCall) {
            return null;
        }
        if (!$this->isNames($firstArgumentValue, ['strpos', 'stripos'])) {
            return null;
        }
        $this->identifierManipulator->renameNodeWithMap($node, self::RENAME_METHODS_MAP);
        return $this->changeArgumentsOrder($node);
    }
    /**
     * @param MethodCall|StaticCall $node
     * @return MethodCall|StaticCall|null
     */
    private function changeArgumentsOrder(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $oldArguments = $node->args;
        $strposFuncCallNode = $oldArguments[0]->value;
        if (!$strposFuncCallNode instanceof \PhpParser\Node\Expr\FuncCall) {
            return null;
        }
        $firstArgument = $strposFuncCallNode->args[1];
        $secondArgument = $strposFuncCallNode->args[0];
        unset($oldArguments[0]);
        $newArgs = [$firstArgument, $secondArgument];
        $node->args = $this->appendArgs($newArgs, $oldArguments);
        return $node;
    }
}
