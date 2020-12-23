<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\Rector\Include_;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Include_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\MagicConst\Dir;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Include_\FollowRequireByDirRector\FollowRequireByDirRectorTest
 */
final class FollowRequireByDirRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('include/require should be followed by absolute path', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        require 'autoload.php';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        require __DIR__ . '/autoload.php';
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Include_::class];
    }
    /**
     * @param Include_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat && $node->expr->left instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_ && $this->isRefactorableStringPath($node->expr->left)) {
            $node->expr->left = $this->prefixWithDir($node->expr->left);
            return $node;
        }
        if ($node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_ && $this->isRefactorableStringPath($node->expr)) {
            $node->expr = $this->prefixWithDir($node->expr);
            return $node;
        }
        // nothing we can do
        return null;
    }
    private function isRefactorableStringPath(\_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_ $string) : bool
    {
        return !\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::startsWith($string->value, 'phar://');
    }
    private function prefixWithDir(\_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_ $string) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat
    {
        $this->removeExtraDotSlash($string);
        $this->prependSlashIfMissing($string);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\MagicConst\Dir(), $string);
    }
    /**
     * Remove "./" which would break the path
     */
    private function removeExtraDotSlash(\_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_ $string) : void
    {
        if (!\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::startsWith($string->value, './')) {
            return;
        }
        $string->value = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::replace($string->value, '#^\\.\\/#', '/');
    }
    private function prependSlashIfMissing(\_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_ $string) : void
    {
        if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::startsWith($string->value, '/')) {
            return;
        }
        $string->value = '/' . $string->value;
    }
}
