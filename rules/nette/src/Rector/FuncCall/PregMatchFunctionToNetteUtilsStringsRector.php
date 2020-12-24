<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Rector\FuncCall;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Minus;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.tomasvotruba.cz/blog/2019/02/07/what-i-learned-by-using-thecodingmachine-safe/#is-there-a-better-way
 *
 * @see \Rector\Nette\Tests\Rector\FuncCall\PregMatchFunctionToNetteUtilsStringsRector\PregMatchFunctionToNetteUtilsStringsRectorTest
 */
final class PregMatchFunctionToNetteUtilsStringsRector extends \_PhpScoperb75b35f52b74\Rector\Nette\Rector\FuncCall\AbstractPregToNetteUtilsStringsRector
{
    /**
     * @var array<string, string>
     */
    private const FUNCTION_NAME_TO_METHOD_NAME = ['preg_match' => 'match', 'preg_match_all' => 'matchAll'];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use Nette\\Utils\\Strings over bare preg_match() and preg_match_all() functions', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $content = 'Hi my name is Tom';
        preg_match('#Hi#', $content, $matches);
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
        $matches = Strings::match($content, '#Hi#');
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical::class];
    }
    /**
     * @param FuncCall|Identical $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical) {
            return $this->refactorIdentical($node);
        }
        return $this->refactorFuncCall($node);
    }
    private function refactorIdentical(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical $identical) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Bool_
    {
        $parentNode = $identical->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($identical->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            $refactoredFuncCall = $this->refactorFuncCall($identical->left);
            if ($refactoredFuncCall !== null && $this->isValue($identical->right, 1)) {
                return $this->createBoolCast($parentNode, $refactoredFuncCall);
            }
        }
        if ($identical->right instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            $refactoredFuncCall = $this->refactorFuncCall($identical->right);
            if ($refactoredFuncCall !== null && $this->isValue($identical->left, 1)) {
                return $this->createBoolCast($parentNode, $refactoredFuncCall);
            }
        }
        return null;
    }
    /**
     * @return FuncCall|StaticCall|Assign|null
     */
    private function refactorFuncCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        $methodName = $this->matchFuncCallRenameToMethod($funcCall, self::FUNCTION_NAME_TO_METHOD_NAME);
        if ($methodName === null) {
            return null;
        }
        $matchStaticCall = $this->createMatchStaticCall($funcCall, $methodName);
        // skip assigns, might be used with different return value
        $parentNode = $funcCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            if ($methodName === 'matchAll') {
                // use count
                return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('count'), [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($matchStaticCall)]);
            }
            return null;
        }
        // assign
        if (isset($funcCall->args[2])) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($funcCall->args[2]->value, $matchStaticCall);
        }
        return $matchStaticCall;
    }
    private function createMatchStaticCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall, string $methodName) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall
    {
        $args = [];
        $args[] = $funcCall->args[1];
        $args[] = $funcCall->args[0];
        $args = $this->compensateMatchAllEnforcedFlag($methodName, $funcCall, $args);
        return $this->createStaticCall('_PhpScoperb75b35f52b74\\Nette\\Utils\\Strings', $methodName, $args);
    }
    /**
     * Compensate enforced flag https://github.com/nette/utils/blob/e3dd1853f56ee9a68bfbb2e011691283c2ed420d/src/Utils/Strings.php#L487
     * See https://stackoverflow.com/a/61424319/1348344
     *
     * @param Arg[] $args
     * @return Arg[]
     */
    private function compensateMatchAllEnforcedFlag(string $methodName, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall, array $args) : array
    {
        if ($methodName !== 'matchAll') {
            return $args;
        }
        if (\count((array) $funcCall->args) !== 3) {
            return $args;
        }
        $constFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('PREG_SET_ORDER'));
        $minus = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Minus($constFetch, new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber(1));
        $args[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($minus);
        return $args;
    }
}
