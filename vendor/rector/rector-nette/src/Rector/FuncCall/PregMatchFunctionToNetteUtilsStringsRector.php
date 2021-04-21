<?php

declare(strict_types=1);

namespace Rector\Nette\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\Rector\AbstractRector;
use Rector\Nette\NodeAnalyzer\PregMatchAllAnalyzer;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see https://tomasvotruba.com/blog/2019/02/07/what-i-learned-by-using-thecodingmachine-safe/#is-there-a-better-way
 *
 * @see \Rector\Nette\Tests\Rector\FuncCall\PregMatchFunctionToNetteUtilsStringsRector\PregMatchFunctionToNetteUtilsStringsRectorTest
 */
final class PregMatchFunctionToNetteUtilsStringsRector extends AbstractRector
{
    /**
     * @var array<string, string>
     */
    const FUNCTION_NAME_TO_METHOD_NAME = [
        'preg_match' => 'match',
        'preg_match_all' => 'matchAll',
    ];

    /**
     * @var PregMatchAllAnalyzer
     */
    private $pregMatchAllAnalyzer;

    public function __construct(PregMatchAllAnalyzer $pregMatchAllAnalyzer)
    {
        $this->pregMatchAllAnalyzer = $pregMatchAllAnalyzer;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Use Nette\Utils\Strings over bare preg_match() and preg_match_all() functions',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $content = 'Hi my name is Tom';
        preg_match('#Hi#', $content, $matches);
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
use Nette\Utils\Strings;

class SomeClass
{
    public function run()
    {
        $content = 'Hi my name is Tom';
        $matches = Strings::match($content, '#Hi#');
    }
}
CODE_SAMPLE
            ),
            ]);
    }

    /**
     * @param FuncCall|Identical $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if ($node instanceof Identical) {
            return $this->refactorIdentical($node);
        }

        return $this->refactorFuncCall($node);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [FuncCall::class, Identical::class];
    }

    /**
     * @return \PhpParser\Node\Expr\Cast\Bool_|null
     */
    public function refactorIdentical(Identical $identical)
    {
        $parentNode = $identical->getAttribute(AttributeKey::PARENT_NODE);

        if ($identical->left instanceof FuncCall) {
            $refactoredFuncCall = $this->refactorFuncCall($identical->left);
            if ($refactoredFuncCall !== null && $this->valueResolver->isValue($identical->right, 1)) {
                return $this->createBoolCast($parentNode, $refactoredFuncCall);
            }
        }

        if ($identical->right instanceof FuncCall) {
            $refactoredFuncCall = $this->refactorFuncCall($identical->right);
            if ($refactoredFuncCall !== null && $this->valueResolver->isValue($identical->left, 1)) {
                return $this->createBoolCast($parentNode, $refactoredFuncCall);
            }
        }

        return null;
    }

    /**
     * @return \PhpParser\Node\Expr|null
     */
    public function refactorFuncCall(FuncCall $funcCall)
    {
        $methodName = $this->nodeNameResolver->matchNameFromMap($funcCall, self::FUNCTION_NAME_TO_METHOD_NAME);
        if ($methodName === null) {
            return null;
        }

        $matchStaticCall = $this->createMatchStaticCall($funcCall, $methodName);

        // skip assigns, might be used with different return value
        $parentNode = $funcCall->getAttribute(AttributeKey::PARENT_NODE);
        if ($parentNode instanceof Assign) {
            if ($methodName === 'matchAll') {
                // use count
                return new FuncCall(new Name('count'), [new Arg($matchStaticCall)]);
            }

            return null;
        }

        // assign
        if (isset($funcCall->args[2])) {
            return new Assign($funcCall->args[2]->value, $matchStaticCall);
        }

        return $matchStaticCall;
    }

    /**
     * @param Expr $expr
     * @param \PhpParser\Node|null $node
     */
    private function createBoolCast($node, Node $expr): Bool_
    {
        if ($node instanceof Return_ && $expr instanceof Assign) {
            $expr = $expr->expr;
        }

        return new Bool_($expr);
    }

    private function createMatchStaticCall(FuncCall $funcCall, string $methodName): StaticCall
    {
        $args = [];
        $args[] = $funcCall->args[1];
        $args[] = $funcCall->args[0];

        $args = $this->pregMatchAllAnalyzer->compensateEnforcedFlag($methodName, $funcCall, $args);
        return $this->nodeFactory->createStaticCall('Nette\Utils\Strings', $methodName, $args);
    }
}
