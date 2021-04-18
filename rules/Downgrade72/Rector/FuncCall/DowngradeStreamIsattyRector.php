<?php

declare (strict_types=1);
namespace Rector\Downgrade72\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Parser\InlineCodeParser;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @changelog https://github.com/symfony/polyfill/commit/cc2bf55accd32b989348e2039e8c91cde46aebed
 *
 * @see \Rector\Tests\Downgrade72\Rector\FuncCall\DowngradeStreamIsattyRector\DowngradeStreamIsattyRectorTest
 */
final class DowngradeStreamIsattyRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var InlineCodeParser
     */
    private $inlineCodeParser;
    public function __construct(\Rector\Core\PhpParser\Parser\InlineCodeParser $inlineCodeParser)
    {
        $this->inlineCodeParser = $inlineCodeParser;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Downgrade stream_isatty() function', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($stream)
    {
        $isStream = stream_isatty($stream);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($stream)
    {
        $streamIsatty = function ($stream) {
            if ('\\' === \DIRECTORY_SEPARATOR) {
                $stat = @fstat($stream);
                return $stat ? 020000 === ($stat['mode'] & 0170000) : false;
            }
            return @posix_isatty($stream);
        };
        $isStream = $streamIsatty($stream);
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isName($node, 'stream_isatty')) {
            return null;
        }
        $function = $this->createClosure();
        $assign = new \PhpParser\Node\Expr\Assign(new \PhpParser\Node\Expr\Variable('streamIsatty'), $function);
        $this->addNodeBeforeNode($assign, $node);
        return new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Expr\Variable('streamIsatty'), $node->args);
    }
    private function createClosure() : \PhpParser\Node\Expr\Closure
    {
        $stmts = $this->inlineCodeParser->parse(__DIR__ . '/../../snippet/isatty_closure.php.inc');
        /** @var Expression $expression */
        $expression = $stmts[0];
        $expr = $expression->expr;
        if (!$expr instanceof \PhpParser\Node\Expr\Closure) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return $expr;
    }
}
