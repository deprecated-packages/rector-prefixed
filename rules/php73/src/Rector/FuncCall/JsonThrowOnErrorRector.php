<?php

declare (strict_types=1);
namespace Rector\Php73\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\LNumber;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see http://wiki.php.net/rfc/json_throw_on_error
 * @see https://3v4l.org/5HMVE
 * @see \Rector\Php73\Tests\Rector\FuncCall\JsonThrowOnErrorRector\JsonThrowOnErrorRectorTest
 */
final class JsonThrowOnErrorRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds JSON_THROW_ON_ERROR to json_encode() and json_decode() to throw JsonException on error', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::JSON_EXCEPTION)) {
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
    private function processJsonEncode(\PhpParser\Node\Expr\FuncCall $funcCall) : ?\PhpParser\Node\Expr\FuncCall
    {
        if (isset($funcCall->args[1])) {
            return null;
        }
        $funcCall->args[1] = new \PhpParser\Node\Arg($this->createConstFetch('JSON_THROW_ON_ERROR'));
        return $funcCall;
    }
    private function processJsonDecode(\PhpParser\Node\Expr\FuncCall $funcCall) : ?\PhpParser\Node\Expr\FuncCall
    {
        if (isset($funcCall->args[3])) {
            return null;
        }
        // set default to inter-args
        if (!isset($funcCall->args[1])) {
            $funcCall->args[1] = new \PhpParser\Node\Arg($this->nodeFactory->createFalse());
        }
        if (!isset($funcCall->args[2])) {
            $funcCall->args[2] = new \PhpParser\Node\Arg(new \PhpParser\Node\Scalar\LNumber(512));
        }
        $funcCall->args[3] = new \PhpParser\Node\Arg($this->createConstFetch('JSON_THROW_ON_ERROR'));
        return $funcCall;
    }
    private function createConstFetch(string $name) : \PhpParser\Node\Expr\ConstFetch
    {
        return new \PhpParser\Node\Expr\ConstFetch(new \PhpParser\Node\Name($name));
    }
}
