<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Rector\Include_;

use RectorPrefix20210317\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\Include_;
use PhpParser\Node\Scalar\MagicConst\Dir;
use PhpParser\Node\Scalar\String_;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\CodingStyle\Rector\Include_\FollowRequireByDirRector\FollowRequireByDirRectorTest
 */
final class FollowRequireByDirRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('include/require should be followed by absolute path', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\Include_::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        if ($node->expr instanceof \PhpParser\Node\Expr\BinaryOp\Concat && $node->expr->left instanceof \PhpParser\Node\Scalar\String_ && $this->isRefactorableStringPath($node->expr->left)) {
            $node->expr->left = $this->prefixWithDir($node->expr->left);
            return $node;
        }
        if ($node->expr instanceof \PhpParser\Node\Scalar\String_ && $this->isRefactorableStringPath($node->expr)) {
            $node->expr = $this->prefixWithDir($node->expr);
            return $node;
        }
        // nothing we can do
        return null;
    }
    /**
     * @param \PhpParser\Node\Scalar\String_ $string
     */
    private function isRefactorableStringPath($string) : bool
    {
        return !\RectorPrefix20210317\Nette\Utils\Strings::startsWith($string->value, 'phar://');
    }
    /**
     * @param \PhpParser\Node\Scalar\String_ $string
     */
    private function prefixWithDir($string) : \PhpParser\Node\Expr\BinaryOp\Concat
    {
        $this->removeExtraDotSlash($string);
        $this->prependSlashIfMissing($string);
        return new \PhpParser\Node\Expr\BinaryOp\Concat(new \PhpParser\Node\Scalar\MagicConst\Dir(), $string);
    }
    /**
     * Remove "./" which would break the path
     * @param \PhpParser\Node\Scalar\String_ $string
     */
    private function removeExtraDotSlash($string) : void
    {
        if (!\RectorPrefix20210317\Nette\Utils\Strings::startsWith($string->value, './')) {
            return;
        }
        $string->value = \RectorPrefix20210317\Nette\Utils\Strings::replace($string->value, '#^\\.\\/#', '/');
    }
    /**
     * @param \PhpParser\Node\Scalar\String_ $string
     */
    private function prependSlashIfMissing($string) : void
    {
        if (\RectorPrefix20210317\Nette\Utils\Strings::startsWith($string->value, '/')) {
            return;
        }
        $string->value = '/' . $string->value;
    }
}
