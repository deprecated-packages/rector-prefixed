<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder\PhpDocumentor;

use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\GroupUse;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse;
use function array_filter;
use function array_map;
use function array_merge;
use function in_array;
class NamespaceNodeToReflectionTypeContext
{
    public function __invoke(?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_ $namespace) : \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context
    {
        if (!$namespace) {
            return new \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context('');
        }
        return new \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context($namespace->name ? $namespace->name->toString() : '', $this->aliasesToFullyQualifiedNames($namespace));
    }
    /**
     * @return string[] indexed by alias
     */
    private function aliasesToFullyQualifiedNames(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        // flatten(flatten(map(stuff)))
        return \array_merge([], ...\array_merge([], ...\array_map(
            /** @param Use_|GroupUse $use */
            static function ($use) : array {
                return \array_map(static function (\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse $useUse) use($use) : array {
                    if ($use instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\GroupUse) {
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
    private function classAlikeUses(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        return \array_filter($namespace->stmts, static function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            return ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_ || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\GroupUse) && \in_array($node->type, [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_::TYPE_UNKNOWN, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_::TYPE_NORMAL], \true);
        });
    }
}
