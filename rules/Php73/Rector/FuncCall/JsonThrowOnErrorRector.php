<?php

declare(strict_types=1);

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
 * @changelog http://wiki.php.net/rfc/json_throw_on_error
 * @see https://3v4l.org/5HMVE
 * @see \Rector\Tests\Php73\Rector\FuncCall\JsonThrowOnErrorRector\JsonThrowOnErrorRectorTest
 */
final class JsonThrowOnErrorRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Adds JSON_THROW_ON_ERROR to json_encode() and json_decode() to throw JsonException on error',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
json_encode($content);
json_decode($json);
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
json_encode($content, JSON_THROW_ON_ERROR);
json_decode($json, null, 512, JSON_THROW_ON_ERROR);
CODE_SAMPLE
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [FuncCall::class];
    }

    /**
     * @param FuncCall $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if (! $this->isAtLeastPhpVersion(PhpVersionFeature::JSON_EXCEPTION)) {
            return null;
        }

        if ($this->shouldSkip($node)) {
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

    private function shouldSkip(FuncCall $funcCall): bool
    {
        if (! $this->isNames($funcCall, ['json_encode', 'json_decode'])) {
            return true;
        }

        return (bool) $this->betterNodeFinder->findFirstNext($funcCall, function (Node $node): bool {
            if (! $node instanceof FuncCall) {
                return false;
            }

            return $this->isNames($node, ['json_last_error', 'json_last_error_msg']);
        });
    }

    /**
     * @return \PhpParser\Node\Expr\FuncCall|null
     */
    private function processJsonEncode(FuncCall $funcCall)
    {
        if (isset($funcCall->args[1])) {
            return null;
        }

        $funcCall->args[1] = new Arg($this->createConstFetch('JSON_THROW_ON_ERROR'));

        return $funcCall;
    }

    /**
     * @return \PhpParser\Node\Expr\FuncCall|null
     */
    private function processJsonDecode(FuncCall $funcCall)
    {
        if (isset($funcCall->args[3])) {
            return null;
        }

        // set default to inter-args
        if (! isset($funcCall->args[1])) {
            $funcCall->args[1] = new Arg($this->nodeFactory->createNull());
        }

        if (! isset($funcCall->args[2])) {
            $funcCall->args[2] = new Arg(new LNumber(512));
        }

        $funcCall->args[3] = new Arg($this->createConstFetch('JSON_THROW_ON_ERROR'));

        return $funcCall;
    }

    private function createConstFetch(string $name): ConstFetch
    {
        return new ConstFetch(new Name($name));
    }
}
