<?php

declare(strict_types=1);

namespace Symplify\SimplePhpDocParser\PhpDocNodeVisitor;

use PHPStan\PhpDocParser\Ast\Node;

final class CallablePhpDocNodeVisitor extends AbstractPhpDocNodeVisitor
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @var string|null
     */
    private $docContent;

    /**
     * @param string|null $docContent
     */
    public function __construct(callable $callable, $docContent = null)
    {
        $this->callable = $callable;
        $this->docContent = $docContent;
    }

    /**
     * @return \PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(Node $node)
    {
        $callable = $this->callable;
        return $callable($node, $this->docContent);
    }
}
