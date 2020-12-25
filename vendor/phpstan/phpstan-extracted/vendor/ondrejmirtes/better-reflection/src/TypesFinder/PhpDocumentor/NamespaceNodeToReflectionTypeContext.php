<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder\PhpDocumentor;

use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context;
use PhpParser\Node;
use PhpParser\Node\Stmt\GroupUse;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\UseUse;
use function array_filter;
use function array_map;
use function array_merge;
use function in_array;
class NamespaceNodeToReflectionTypeContext
{
    public function __invoke(?\PhpParser\Node\Stmt\Namespace_ $namespace) : \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context
    {
        if (!$namespace) {
            return new \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context('');
        }
        return new \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context($namespace->name ? $namespace->name->toString() : '', $this->aliasesToFullyQualifiedNames($namespace));
    }
    /**
     * @return string[] indexed by alias
     */
    private function aliasesToFullyQualifiedNames(\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        // flatten(flatten(map(stuff)))
        return \array_merge([], ...\array_merge([], ...\array_map(
            /** @param Use_|GroupUse $use */
            static function ($use) : array {
                return \array_map(static function (\PhpParser\Node\Stmt\UseUse $useUse) use($use) : array {
                    if ($use instanceof \PhpParser\Node\Stmt\GroupUse) {
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
    private function classAlikeUses(\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        return \array_filter($namespace->stmts, static function (\PhpParser\Node $node) : bool {
            return ($node instanceof \PhpParser\Node\Stmt\Use_ || $node instanceof \PhpParser\Node\Stmt\GroupUse) && \in_array($node->type, [\PhpParser\Node\Stmt\Use_::TYPE_UNKNOWN, \PhpParser\Node\Stmt\Use_::TYPE_NORMAL], \true);
        });
    }
}
