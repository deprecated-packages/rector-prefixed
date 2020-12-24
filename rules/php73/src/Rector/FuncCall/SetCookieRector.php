<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php73\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Convert legacy setcookie arguments to new array options
 *
 * @see \Rector\Php73\Tests\Rector\FuncCall\SetcookieRector\SetCookieRectorTest
 *
 * @see https://www.php.net/setcookie
 * @see https://wiki.php.net/rfc/same-site-cookie
 */
final class SetCookieRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * Conversion table from argument index to options name
     * @var array<int, string>
     */
    private const KNOWN_OPTIONS = [2 => 'expires', 3 => 'path', 4 => 'domain', 5 => 'secure', 6 => 'httponly'];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert setcookie argument to PHP7.3 option array', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
setcookie('name', $value, 360);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
setcookie('name', $value, ['expires' => 360]);
CODE_SAMPLE
), new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
setcookie('name', $name, 0, '', '', true, true);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
setcookie('name', $name, ['expires' => 0, 'path' => '', 'domain' => '', 'secure' => true, 'httponly' => true]);
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
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var FuncCall $node */
        $node->args = $this->composeNewArgs($node);
        return $node;
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : bool
    {
        if (!$this->isNames($funcCall, ['setcookie', 'setrawcookie'])) {
            return \true;
        }
        if (!$this->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::SETCOOKIE_ACCEPT_ARRAY_OPTIONS)) {
            return \true;
        }
        $argsCount = \count((array) $funcCall->args);
        if ($argsCount <= 2) {
            return \true;
        }
        if ($funcCall->args[2]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_) {
            return \true;
        }
        if ($argsCount === 3) {
            return $funcCall->args[2]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
        }
        return \false;
    }
    /**
     * @return Arg[]
     */
    private function composeNewArgs(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : array
    {
        $items = [];
        $args = $funcCall->args;
        $newArgs = [];
        $newArgs[] = $args[0];
        $newArgs[] = $args[1];
        unset($args[0]);
        unset($args[1]);
        foreach ($args as $idx => $arg) {
            $newKey = new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_(self::KNOWN_OPTIONS[$idx]);
            $items[] = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem($arg->value, $newKey);
        }
        $newArgs[] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_($items));
        return $newArgs;
    }
}
