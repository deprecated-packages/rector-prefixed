<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php73\Rector\FuncCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see http://wiki.php.net/rfc/json_throw_on_error
 * @see https://3v4l.org/5HMVE
 * @see \Rector\Php73\Tests\Rector\FuncCall\JsonThrowOnErrorRector\JsonThrowOnErrorRectorTest
 */
final class JsonThrowOnErrorRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds JSON_THROW_ON_ERROR to json_encode() and json_decode() to throw JsonException on error', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
json_encode($content);
json_decode($json);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
json_encode($content, JSON_THROW_ON_ERROR);
json_decode($json, null, null, JSON_THROW_ON_ERROR);
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::JSON_EXCEPTION)) {
            return null;
        }
        if ($this->isName($node, 'json_encode')) {
            return $this->processJsonEncode($node);
        }
        if ($this->isName($node, 'json_decode')) {
            return $this->processJsonDecode($node);
        }
        return null;
    }
    private function processJsonEncode(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall
    {
        if (isset($funcCall->args[1])) {
            return null;
        }
        $funcCall->args[1] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($this->createConstFetch('JSON_THROW_ON_ERROR'));
        return $funcCall;
    }
    private function processJsonDecode(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall
    {
        if (isset($funcCall->args[3])) {
            return null;
        }
        // set default to inter-args
        if (!isset($funcCall->args[1])) {
            $funcCall->args[1] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($this->createFalse());
        }
        if (!isset($funcCall->args[2])) {
            $funcCall->args[2] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg(new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber(512));
        }
        $funcCall->args[3] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($this->createConstFetch('JSON_THROW_ON_ERROR'));
        return $funcCall;
    }
    private function createConstFetch(string $name) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch
    {
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($name));
    }
}
