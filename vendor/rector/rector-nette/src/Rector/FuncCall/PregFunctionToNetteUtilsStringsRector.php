<?php

declare(strict_types=1);

namespace Rector\Nette\Rector\FuncCall;

use Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp\BitwiseAnd;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BitwiseNot;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see https://tomasvotruba.com/blog/2019/02/07/what-i-learned-by-using-thecodingmachine-safe/#is-there-a-better-way
 *
 * @see \Rector\Nette\Tests\Rector\FuncCall\PregFunctionToNetteUtilsStringsRector\PregFunctionToNetteUtilsStringsRectorTest
 */
final class PregFunctionToNetteUtilsStringsRector extends AbstractRector
{
    /**
     * @var array<string, string>
     */
    const FUNCTION_NAME_TO_METHOD_NAME = [
        'preg_split' => 'split',
        'preg_replace' => 'replace',
        'preg_replace_callback' => 'replace',
    ];

    /**
     * @see https://regex101.com/r/05MPWa/1/
     * @var string
     */
    const SLASH_REGEX = '#[^\\\\]\(#';

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Use Nette\Utils\Strings over bare preg_split() and preg_replace() functions',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $content = 'Hi my name is Tom';
        $splitted = preg_split('#Hi#', $content);
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
        $splitted = \Nette\Utils\Strings::split($content, '#Hi#');
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
                return new Bool_($refactoredFuncCall);
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
            if ($methodName === 'split') {
                return $this->processSplit($funcCall, $matchStaticCall);
            }

            if ($methodName === 'replace') {
                return $matchStaticCall;
            }

            return null;
        }

        $currentFunctionName = $this->getName($funcCall);

        // assign
        if (isset($funcCall->args[2]) && $currentFunctionName !== 'preg_replace') {
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

        if ($methodName === 'replace') {
            $args[] = $funcCall->args[2];
            $args[] = $funcCall->args[0];
            $args[] = $funcCall->args[1];
        } else {
            $args[] = $funcCall->args[1];
            $args[] = $funcCall->args[0];
        }

        return $this->nodeFactory->createStaticCall('Nette\Utils\Strings', $methodName, $args);
    }

    /**
     * @return FuncCall|StaticCall
     */
    private function processSplit(FuncCall $funcCall, StaticCall $matchStaticCall): Expr
    {
        $this->compensateNetteUtilsSplitDelimCapture($matchStaticCall);

        if (! isset($funcCall->args[2])) {
            return $matchStaticCall;
        }

        if ($this->valueResolver->isValue($funcCall->args[2]->value, -1)) {
            if (isset($funcCall->args[3])) {
                $matchStaticCall->args[] = $funcCall->args[3];
            }

            return $matchStaticCall;
        }

        return $funcCall;
    }

    /**
     * Handles https://github.com/rectorphp/rector/issues/2348
     * @return void
     */
    private function compensateNetteUtilsSplitDelimCapture(StaticCall $staticCall)
    {
        $patternValue = $this->valueResolver->getValue($staticCall->args[1]->value);
        if (! is_string($patternValue)) {
            return;
        }

        $match = Strings::match($patternValue, self::SLASH_REGEX);
        if ($match === null) {
            return;
        }

        $constFetch = new ConstFetch(new Name('PREG_SPLIT_DELIM_CAPTURE'));
        $bitwiseAnd = new BitwiseAnd(new LNumber(0), new BitwiseNot($constFetch));
        $staticCall->args[2] = new Arg($bitwiseAnd);
    }
}
