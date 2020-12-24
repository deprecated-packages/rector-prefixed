<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php74\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/deprecations_php_7_4 (not confirmed yet)
 * @see https://3v4l.org/dJgXd
 * @see \Rector\Php74\Tests\Rector\FuncCall\GetCalledClassToStaticClassRector\GetCalledClassToStaticClassRectorTest
 */
final class GetCalledClassToStaticClassRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change get_called_class() to static::class', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
   public function callOnMe()
   {
       var_dump(get_called_class());
   }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
   public function callOnMe()
   {
       var_dump(static::class);
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::CLASSNAME_CONSTANT)) {
            return null;
        }
        if (!$this->isName($node, 'get_called_class')) {
            return null;
        }
        return $this->createClassConstFetch('static', 'class');
    }
}
