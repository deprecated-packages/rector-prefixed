<?php

declare (strict_types=1);
namespace Rector\Core\Exclusion\Check;

use _PhpScoper26e51eeacccf\Nette\Utils\Strings;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Const_;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\PropertyProperty;
use Rector\Core\Contract\Exclusion\ExclusionCheckInterface;
use Rector\Core\Contract\Rector\PhpRectorInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\Core\Tests\Exclusion\Check\ExcludeByDocBlockExclusionCheckTest
 */
final class ExcludeByDocBlockExclusionCheck implements \Rector\Core\Contract\Exclusion\ExclusionCheckInterface
{
    /**
     * @var string
     * @see https://regex101.com/r/d1NMi6/1
     */
    private const NO_RECTORE_ANNOTATION_WITH_CLASS_REGEX = '#\\@noRector(\\s)+[^\\w\\\\]#i';
    public function isNodeSkippedByRector(\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \PhpParser\Node $node) : bool
    {
        if ($node instanceof \PhpParser\Node\Stmt\PropertyProperty || $node instanceof \PhpParser\Node\Const_) {
            $node = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($node === null) {
                return \false;
            }
        }
        $doc = $node->getDocComment();
        if ($doc !== null && $this->hasNoRectorComment($phpRector, $doc)) {
            return \true;
        }
        // recurse up until a Stmt node is found since it might contain a noRector
        $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$node instanceof \PhpParser\Node\Stmt && $parentNode !== null) {
            return $this->isNodeSkippedByRector($phpRector, $parentNode);
        }
        return \false;
    }
    private function hasNoRectorComment(\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, \PhpParser\Comment\Doc $doc) : bool
    {
        // bare @noRector ignored all rules
        if (\_PhpScoper26e51eeacccf\Nette\Utils\Strings::match($doc->getText(), self::NO_RECTORE_ANNOTATION_WITH_CLASS_REGEX)) {
            return \true;
        }
        $regex = '#@noRector\\s*\\\\?' . \preg_quote(\get_class($phpRector), '/') . '#i';
        return (bool) \_PhpScoper26e51eeacccf\Nette\Utils\Strings::match($doc->getText(), $regex);
    }
}
