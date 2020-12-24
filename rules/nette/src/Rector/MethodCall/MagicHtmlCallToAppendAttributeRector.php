<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/nette/utils/commit/75abe7c6aa472fd023aa49ba1a4d6c6eca0eaaa6
 * @see https://github.com/nette/utils/issues/88
 *
 * @see \Rector\Nette\Tests\Rector\MethodCall\MagicHtmlCallToAppendAttributeRector\MagicHtmlCallToAppendAttributeRectorTest
 */
final class MagicHtmlCallToAppendAttributeRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change magic addClass() etc. calls on Html to explicit methods', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\Utils\Html;

final class SomeClass
{
    public function run()
    {
        $html = Html::el();
        $html->setClass('first');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\Utils\Html;

final class SomeClass
{
    public function run()
    {
        $html = Html::el();
        $html->appendAttribute('class', 'first');
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isObjectType($node->var, '_PhpScoperb75b35f52b74\\Nette\\Utils\\Html')) {
            return null;
        }
        // @todo posibly extends by more common names
        if ($this->isName($node->name, 'setClass')) {
            $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier('appendAttribute');
            $args = \array_merge([new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg(new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_('class'))], $node->args);
            $node->args = $args;
            return $node;
        }
        return null;
    }
}
