<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteKdyby\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node;
final class GetterMethodBlueprint
{
    /**
     * @var string
     */
    private $methodName;
    /**
     * @var string
     */
    private $variableName;
    /**
     * @var Node|null
     */
    private $returnTypeNode;
    public function __construct(string $methodName, ?\_PhpScoperb75b35f52b74\PhpParser\Node $returnTypeNode, string $variableName)
    {
        $this->methodName = $methodName;
        $this->returnTypeNode = $returnTypeNode;
        $this->variableName = $variableName;
    }
    public function getMethodName() : string
    {
        return $this->methodName;
    }
    public function getReturnTypeNode() : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->returnTypeNode;
    }
    public function getVariableName() : string
    {
        return $this->variableName;
    }
}
