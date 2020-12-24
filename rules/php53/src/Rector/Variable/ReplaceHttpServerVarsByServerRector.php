<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php53\Rector\Variable;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://twitter.com/afilina & Zenika (CAN) for sponsoring this rule - visit them on https://zenika.ca/en/en
 *
 * @see \Rector\Php53\Tests\Rector\Variable\ReplaceHttpServerVarsByServerRector\ReplaceHttpServerVarsByServerRectorTest
 * @see https://blog.tigertech.net/posts/php-5-3-http-server-vars/
 */
final class ReplaceHttpServerVarsByServerRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const VARIABLE_RENAME_MAP = ['HTTP_SERVER_VARS' => '_SERVER', 'HTTP_GET_VARS' => '_GET', 'HTTP_POST_VARS' => '_POST', 'HTTP_POST_FILES' => '_FILES', 'HTTP_SESSION_VARS' => '_SESSION', 'HTTP_ENV_VARS' => '_ENV', 'HTTP_COOKIE_VARS' => '_COOKIE'];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename old $HTTP_* variable names to new replacements', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$serverVars = $HTTP_SERVER_VARS;', '$serverVars = $_SERVER;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable::class];
    }
    /**
     * @param Variable $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach (self::VARIABLE_RENAME_MAP as $oldName => $newName) {
            if (!$this->isName($node, $oldName)) {
                continue;
            }
            $node->name = $newName;
            return $node;
        }
        return null;
    }
}
