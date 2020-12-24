<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
final class ConcatStringAndPlaceholders
{
    /**
     * @var string
     */
    private $content;
    /**
     * @var Expr[]
     */
    private $placeholderNodes = [];
    /**
     * @param Expr[] $placeholderNodes
     */
    public function __construct(string $content, array $placeholderNodes)
    {
        $this->content = $content;
        $this->placeholderNodes = $placeholderNodes;
    }
    public function getContent() : string
    {
        return $this->content;
    }
    /**
     * @return Expr[]
     */
    public function getPlaceholderNodes() : array
    {
        return $this->placeholderNodes;
    }
}
