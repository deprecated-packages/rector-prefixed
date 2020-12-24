<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
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
