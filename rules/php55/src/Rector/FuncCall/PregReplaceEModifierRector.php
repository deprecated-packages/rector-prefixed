<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php55\Rector\FuncCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Php55\NodeFactory\AnonymousFunctionNodeFactory;
use _PhpScoper0a2ac50786fa\Rector\Php55\RegexMatcher;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/remove_preg_replace_eval_modifier
 * @see https://stackoverflow.com/q/19245205/1348344
 *
 * @see \Rector\Php55\Tests\Rector\FuncCall\PregReplaceEModifierRector\PregReplaceEModifierRectorTest
 */
final class PregReplaceEModifierRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var RegexMatcher
     */
    private $regexMatcher;
    /**
     * @var AnonymousFunctionNodeFactory
     */
    private $anonymousFunctionNodeFactory;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Php55\NodeFactory\AnonymousFunctionNodeFactory $anonymousFunctionNodeFactory, \_PhpScoper0a2ac50786fa\Rector\Php55\RegexMatcher $regexMatcher)
    {
        $this->regexMatcher = $regexMatcher;
        $this->anonymousFunctionNodeFactory = $anonymousFunctionNodeFactory;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('The /e modifier is no longer supported, use preg_replace_callback instead', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $comment = preg_replace('~\b(\w)(\w+)~e', '"$1".strtolower("$2")', $comment);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $comment = preg_replace_callback('~\b(\w)(\w+)~', function ($matches) {
              return($matches[1].strtolower($matches[2]));
        }, , $comment);
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isName($node, 'preg_replace')) {
            return null;
        }
        $firstArgumentValue = $node->args[0]->value;
        $patternWithoutE = $this->regexMatcher->resolvePatternExpressionWithoutEIfFound($firstArgumentValue);
        if ($patternWithoutE === null) {
            return null;
        }
        $secondArgumentValue = $node->args[1]->value;
        $anonymousFunction = $this->anonymousFunctionNodeFactory->createAnonymousFunctionFromString($secondArgumentValue);
        if ($anonymousFunction === null) {
            return null;
        }
        $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('preg_replace_callback');
        $node->args[0]->value = $patternWithoutE;
        $node->args[1]->value = $anonymousFunction;
        return $node;
    }
}
