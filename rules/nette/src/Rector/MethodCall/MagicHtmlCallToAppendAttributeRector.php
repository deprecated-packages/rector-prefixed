<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Nette\Rector\MethodCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/nette/utils/commit/75abe7c6aa472fd023aa49ba1a4d6c6eca0eaaa6
 * @see https://github.com/nette/utils/issues/88
 *
 * @see \Rector\Nette\Tests\Rector\MethodCall\MagicHtmlCallToAppendAttributeRector\MagicHtmlCallToAppendAttributeRectorTest
 */
final class MagicHtmlCallToAppendAttributeRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change magic addClass() etc. calls on Html to explicit methods', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isObjectType($node->var, '_PhpScoper0a2ac50786fa\\Nette\\Utils\\Html')) {
            return null;
        }
        // @todo posibly extends by more common names
        if ($this->isName($node->name, 'setClass')) {
            $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier('appendAttribute');
            $args = \array_merge([new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_('class'))], $node->args);
            $node->args = $args;
            return $node;
        }
        return null;
    }
}
