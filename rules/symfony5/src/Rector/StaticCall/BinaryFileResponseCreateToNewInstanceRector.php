<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony5\Rector\StaticCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#httpfoundation
 * @see \Rector\Symfony5\Tests\Rector\StaticCall\BinaryFileResponseCreateToNewInstanceRector\BinaryFileResponseCreateToNewInstanceRectorTest
 */
final class BinaryFileResponseCreateToNewInstanceRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change deprecated BinaryFileResponse::create() to use __construct() instead', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\HttpFoundation;

class SomeClass
{
    public function run()
    {
        $binaryFile = BinaryFileResponse::create();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\HttpFoundation;

class SomeClass
{
    public function run()
    {
        $binaryFile = new BinaryFileResponse(null);
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$node->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            return null;
        }
        if (!$this->isName($node->class, '_PhpScopere8e811afab72\\Symfony\\Component\\HttpFoundation\\BinaryFileResponse')) {
            return null;
        }
        if (!$this->isName($node->name, 'create')) {
            return null;
        }
        $args = $node->args;
        if ($args === []) {
            $args[] = $this->createArg($this->createNull());
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_($node->class, $args);
    }
}
