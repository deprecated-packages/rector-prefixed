<?php

declare (strict_types=1);
namespace RectorPrefix20210423\Symplify\SimplePhpDocParser\PhpDocNodeVisitor;

use PHPStan\PhpDocParser\Ast\Node;
final class CallablePhpDocNodeVisitor extends \RectorPrefix20210423\Symplify\SimplePhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor
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
     * @param \PHPStan\PhpDocParser\Ast\Node $node
     * @return \PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode($node)
    {
        $callable = $this->callable;
        return $callable($node, $this->docContent);
    }
}
