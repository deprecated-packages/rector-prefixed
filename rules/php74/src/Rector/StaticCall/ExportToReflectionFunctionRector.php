<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php74\Rector\StaticCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/deprecations_php_7_4 (not confirmed yet)
 * @see https://3v4l.org/RTCUq
 * @see \Rector\Php74\Tests\Rector\StaticCall\ExportToReflectionFunctionRector\ExportToReflectionFunctionRectorTest
 */
final class ExportToReflectionFunctionRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change export() to ReflectionFunction alternatives', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$reflectionFunction = ReflectionFunction::export('foo');
$reflectionFunctionAsString = ReflectionFunction::export('foo', true);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$reflectionFunction = new ReflectionFunction('foo');
$reflectionFunctionAsString = (string) new ReflectionFunction('foo');
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
        if (!$this->isStaticCallNamed($node, 'ReflectionFunction', 'export')) {
            return null;
        }
        $new = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_($node->class, [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($node->args[0]->value)]);
        if (isset($node->args[1]) && $this->isTrue($node->args[1]->value)) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\String_($new);
        }
        return $new;
    }
}
