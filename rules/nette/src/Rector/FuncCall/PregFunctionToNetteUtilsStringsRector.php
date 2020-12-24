<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BitwiseAnd;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BitwiseNot;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.tomasvotruba.cz/blog/2019/02/07/what-i-learned-by-using-thecodingmachine-safe/#is-there-a-better-way
 *
 * @see \Rector\Nette\Tests\Rector\FuncCall\PregFunctionToNetteUtilsStringsRector\PregFunctionToNetteUtilsStringsRectorTest
 */
final class PregFunctionToNetteUtilsStringsRector extends \_PhpScoper0a6b37af0871\Rector\Nette\Rector\FuncCall\AbstractPregToNetteUtilsStringsRector
{
    /**
     * @var array<string, string>
     */
    private const FUNCTION_NAME_TO_METHOD_NAME = ['preg_split' => 'split', 'preg_replace' => 'replace', 'preg_replace_callback' => 'replace'];
    /**
     * @see https://regex101.com/r/05MPWa/1/
     * @var string
     */
    private const SLASH_REGEX = '#[^\\\\]\\(#';
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use Nette\\Utils\\Strings over bare preg_split() and preg_replace() functions', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $content = 'Hi my name is Tom';
        $splitted = preg_split('#Hi#', $content);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
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
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical::class];
    }
    /**
     * @param FuncCall|Identical $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical) {
            return $this->refactorIdentical($node);
        }
        return $this->refactorFuncCall($node);
    }
    private function refactorIdentical(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical $identical) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_
    {
        $parentNode = $identical->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($identical->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            $refactoredFuncCall = $this->refactorFuncCall($identical->left);
            if ($refactoredFuncCall !== null && $this->isValue($identical->right, 1)) {
                return $this->createBoolCast($parentNode, $refactoredFuncCall);
            }
        }
        if ($identical->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
            $refactoredFuncCall = $this->refactorFuncCall($identical->right);
            if ($refactoredFuncCall !== null && $this->isValue($identical->left, 1)) {
                return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_($refactoredFuncCall);
            }
        }
        return null;
    }
    /**
     * @return FuncCall|StaticCall|Assign|null
     */
    private function refactorFuncCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        $methodName = $this->matchFuncCallRenameToMethod($funcCall, self::FUNCTION_NAME_TO_METHOD_NAME);
        if ($methodName === null) {
            return null;
        }
        $matchStaticCall = $this->createMatchStaticCall($funcCall, $methodName);
        // skip assigns, might be used with different return value
        $parentNode = $funcCall->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
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
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign($funcCall->args[2]->value, $matchStaticCall);
        }
        return $matchStaticCall;
    }
    private function createMatchStaticCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall, string $methodName) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall
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
        return $this->createStaticCall('_PhpScoper0a6b37af0871\\Nette\\Utils\\Strings', $methodName, $args);
    }
    /**
     * @return FuncCall|StaticCall
     */
    private function processSplit(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $matchStaticCall) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        $matchStaticCall = $this->compensateNetteUtilsSplitDelimCapture($matchStaticCall);
        if (!isset($funcCall->args[2])) {
            return $matchStaticCall;
        }
        if ($this->isValue($funcCall->args[2]->value, -1)) {
            if (isset($funcCall->args[3])) {
                $matchStaticCall->args[] = $funcCall->args[3];
            }
            return $matchStaticCall;
        }
        return $funcCall;
    }
    /**
     * Handles https://github.com/rectorphp/rector/issues/2348
     */
    private function compensateNetteUtilsSplitDelimCapture(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall
    {
        $patternValue = $this->getValue($staticCall->args[1]->value);
        if (!\is_string($patternValue)) {
            return $staticCall;
        }
        $match = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($patternValue, self::SLASH_REGEX);
        if ($match === null) {
            return $staticCall;
        }
        $constFetch = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('PREG_SPLIT_DELIM_CAPTURE'));
        $bitwiseAnd = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BitwiseAnd(new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber(0), new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BitwiseNot($constFetch));
        $staticCall->args[2] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($bitwiseAnd);
        return $staticCall;
    }
}
