<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\Include_;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Include_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\MagicConst\Dir;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Include_\FollowRequireByDirRector\FollowRequireByDirRectorTest
 */
final class FollowRequireByDirRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('include/require should be followed by absolute path', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Include_::class];
    }
    /**
     * @param Include_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat && $node->expr->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_ && $this->isRefactorableStringPath($node->expr->left)) {
            $node->expr->left = $this->prefixWithDir($node->expr->left);
            return $node;
        }
        if ($node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_ && $this->isRefactorableStringPath($node->expr)) {
            $node->expr = $this->prefixWithDir($node->expr);
            return $node;
        }
        // nothing we can do
        return null;
    }
    private function isRefactorableStringPath(\_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_ $string) : bool
    {
        return !\_PhpScoperb75b35f52b74\Nette\Utils\Strings::startsWith($string->value, 'phar://');
    }
    private function prefixWithDir(\_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_ $string) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat
    {
        $this->removeExtraDotSlash($string);
        $this->prependSlashIfMissing($string);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat(new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\MagicConst\Dir(), $string);
    }
    /**
     * Remove "./" which would break the path
     */
    private function removeExtraDotSlash(\_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_ $string) : void
    {
        if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::startsWith($string->value, './')) {
            return;
        }
        $string->value = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::replace($string->value, '#^\\.\\/#', '/');
    }
    private function prependSlashIfMissing(\_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_ $string) : void
    {
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::startsWith($string->value, '/')) {
            return;
        }
        $string->value = '/' . $string->value;
    }
}
