<?php

declare (strict_types=1);
namespace RectorPrefix20210305\Symplify\Astral\NodeFinder;

use PhpParser\Node;
use RectorPrefix20210305\Symplify\Astral\ValueObject\CommonAttributeKey;
use RectorPrefix20210305\Symplify\PackageBuilder\Php\TypeChecker;
final class ParentNodeFinder
{
    /**
     * @var TypeChecker
     */
    private $typeChecker;
    public function __construct(\RectorPrefix20210305\Symplify\PackageBuilder\Php\TypeChecker $typeChecker)
    {
        $this->typeChecker = $typeChecker;
    }
    /**
     * @see https://phpstan.org/blog/generics-in-php-using-phpdocs for template
     *
     * @template T of Node
     * @param class-string<T> $nodeClass
     * @return T|null
     */
    public function findFirstParentByType(\PhpParser\Node $node, string $nodeClass) : ?\PhpParser\Node
    {
        $node = $node->getAttribute(\RectorPrefix20210305\Symplify\Astral\ValueObject\CommonAttributeKey::PARENT);
        while ($node) {
            if (\is_a($node, $nodeClass, \true)) {
                return $node;
            }
            $node = $node->getAttribute(\RectorPrefix20210305\Symplify\Astral\ValueObject\CommonAttributeKey::PARENT);
        }
        return null;
    }
    /**
     * @template T of Node
     * @param class-string<T>[] $nodeTypes
     * @return T|null
     */
    public function findFirstParentByTypes(\PhpParser\Node $node, array $nodeTypes) : ?\PhpParser\Node
    {
        $node = $node->getAttribute(\RectorPrefix20210305\Symplify\Astral\ValueObject\CommonAttributeKey::PARENT);
        while ($node) {
            if ($this->typeChecker->isInstanceOf($node, $nodeTypes)) {
                return $node;
            }
            $node = $node->getAttribute(\RectorPrefix20210305\Symplify\Astral\ValueObject\CommonAttributeKey::PARENT);
        }
        return null;
    }
}
