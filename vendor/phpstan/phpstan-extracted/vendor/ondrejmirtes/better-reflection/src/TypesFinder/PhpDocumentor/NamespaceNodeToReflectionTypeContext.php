<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder\PhpDocumentor;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\GroupUse;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse;
use function array_filter;
use function array_map;
use function array_merge;
use function in_array;
class NamespaceNodeToReflectionTypeContext
{
    public function __invoke(?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ $namespace) : \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context
    {
        if (!$namespace) {
            return new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context('');
        }
        return new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context($namespace->name ? $namespace->name->toString() : '', $this->aliasesToFullyQualifiedNames($namespace));
    }
    /**
     * @return string[] indexed by alias
     */
    private function aliasesToFullyQualifiedNames(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        // flatten(flatten(map(stuff)))
        return \array_merge([], ...\array_merge([], ...\array_map(
            /** @param Use_|GroupUse $use */
            static function ($use) : array {
                return \array_map(static function (\_PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse $useUse) use($use) : array {
                    if ($use instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\GroupUse) {
                        return [$useUse->getAlias()->toString() => $use->prefix->toString() . '\\' . $useUse->name->toString()];
                    }
                    return [$useUse->getAlias()->toString() => $useUse->name->toString()];
                }, $use->uses);
            },
            $this->classAlikeUses($namespace)
        )));
    }
    /**
     * @return Use_[]|GroupUse[]
     */
    private function classAlikeUses(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        return \array_filter($namespace->stmts, static function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            return ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_ || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\GroupUse) && \in_array($node->type, [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_::TYPE_UNKNOWN, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_::TYPE_NORMAL], \true);
        });
    }
}
