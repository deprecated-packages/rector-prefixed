<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Phalcon\Rector\Assign;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/rectorphp/rector/issues/2408#issue-534441142
 *
 * @see \Rector\Phalcon\Tests\Rector\Assign\FlashWithCssClassesToExtraCallRector\FlashWithCssClassesToExtraCallRectorTest
 */
final class FlashWithCssClassesToExtraCallRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add $cssClasses in Flash to separated method call', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $cssClasses = [];
        $flash = new Phalcon\Flash($cssClasses);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $cssClasses = [];
        $flash = new Phalcon\Flash();
        $flash->setCssClasses($cssClasses);
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_) {
            return null;
        }
        if (!$this->isName($node->expr->class, '_PhpScoperb75b35f52b74\\Phalcon\\Flash')) {
            return null;
        }
        if (!isset($node->expr->args[0])) {
            return null;
        }
        $argument = $node->expr->args[0];
        // remove arg
        unset($node->expr->args[0]);
        // change the node
        $variable = $node->var;
        $setCssClassesMethodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($variable, 'setCssClasses', [$argument]);
        $this->addNodeAfterNode($setCssClassesMethodCall, $node);
        return $node;
    }
}
