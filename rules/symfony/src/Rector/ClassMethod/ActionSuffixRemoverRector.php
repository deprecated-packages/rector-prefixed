<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Symfony\Bridge\NodeAnalyzer\ControllerMethodAnalyzer;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony\Tests\Rector\ClassMethod\ActionSuffixRemoverRector\ActionSuffixRemoverRectorTest
 */
final class ActionSuffixRemoverRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ControllerMethodAnalyzer
     */
    private $controllerMethodAnalyzer;
    /**
     * @var IdentifierManipulator
     */
    private $identifierManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Symfony\Bridge\NodeAnalyzer\ControllerMethodAnalyzer $controllerMethodAnalyzer, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\IdentifierManipulator $identifierManipulator)
    {
        $this->controllerMethodAnalyzer = $controllerMethodAnalyzer;
        $this->identifierManipulator = $identifierManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes Action suffixes from methods in Symfony Controllers', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeController
{
    public function indexAction()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeController
{
    public function index()
    {
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->controllerMethodAnalyzer->isAction($node)) {
            return null;
        }
        $this->identifierManipulator->removeSuffix($node, 'Action');
        return $node;
    }
}
