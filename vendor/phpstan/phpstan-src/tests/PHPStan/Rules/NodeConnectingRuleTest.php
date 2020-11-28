<?php

declare (strict_types=1);
namespace PHPStan\Rules;

use PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<NodeConnectingRule>
 */
class NodeConnectingRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\NodeConnectingRule();
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/node-connecting.php'], [['_PhpScoperabd03f0baf05\\Parent: PhpParser\\Node\\Stmt\\If_, previous: PhpParser\\Node\\Stmt\\Switch_, next: PhpParser\\Node\\Stmt\\Foreach_', 11]]);
    }
}
