<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony5\Rector\New_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/blob/5.x/UPGRADE-5.2.md#form
 * @see \Rector\Symfony5\Tests\Rector\New_\PropertyPathMapperToDataMapperRector\PropertyPathMapperToDataMapperRectorTest
 */
final class PropertyPathMapperToDataMapperRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Migrate from PropertyPathMapper to DataMapper and PropertyPathAccessor', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\Form\Extension\Core\DataMapper\PropertyPathMapper;

class SomeClass
{
    public function run()
    {
        return new PropertyPathMapper();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Form\Extension\Core\DataMapper\PropertyPathMapper;

class SomeClass
{
    public function run()
    {
        return new \Symfony\Component\Form\Extension\Core\DataMapper\DataMapper(new \Symfony\Component\Form\Extension\Core\DataAccessor\PropertyPathAccessor());
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        return $this->generateNewInstances($node);
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $new) : bool
    {
        if (!$new->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            return \true;
        }
        return !$this->isName($new->class, '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\DataMapper\\PropertyPathMapper');
    }
    private function generateNewInstances(\_PhpScopere8e811afab72\PhpParser\Node\Expr\New_ $new) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_
    {
        $arguments = [];
        if (isset($new->args[0])) {
            $arguments = [$new->args[0]];
        }
        $new = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\DataAccessor\\PropertyPathAccessor'), $arguments);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Extension\\Core\\DataMapper\\DataMapper'), [$this->createArg($new)]);
    }
}
