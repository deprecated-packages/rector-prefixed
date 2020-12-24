<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\Rector\Identical;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/add_str_starts_with_and_ends_with_functions
 *
 * @see https://3v4l.org/RQHB5 for weak compare
 * @see https://3v4l.org/AmLja for weak compare
 *
 * @see \Rector\Php80\Tests\Rector\Identical\StrStartsWithRector\StrStartsWithRectorTest
 */
final class StrStartsWithRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var StrStartWithMatchAndRefactorInterface[]
     */
    private $strStartWithMatchAndRefactors = [];
    /**
     * @param StrStartWithMatchAndRefactorInterface[] $strStartWithMatchAndRefactors
     */
    public function __construct(array $strStartWithMatchAndRefactors)
    {
        $this->strStartWithMatchAndRefactors = $strStartWithMatchAndRefactors;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change helper functions to str_starts_with()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $isMatch = substr($haystack, 0, strlen($needle)) === $needle;

        $isNotMatch = substr($haystack, 0, strlen($needle)) !== $needle;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $isMatch = str_starts_with($haystack, $needle);

        $isNotMatch = ! str_starts_with($haystack, $needle);
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->strStartWithMatchAndRefactors as $strStartWithMatchAndRefactor) {
            $strStartsWithValueObject = $strStartWithMatchAndRefactor->match($node);
            if ($strStartsWithValueObject === null) {
                continue;
            }
            return $strStartWithMatchAndRefactor->refactorStrStartsWith($strStartsWithValueObject);
        }
        return null;
    }
}
