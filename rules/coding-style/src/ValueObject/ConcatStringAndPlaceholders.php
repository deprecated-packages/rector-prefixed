<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
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
