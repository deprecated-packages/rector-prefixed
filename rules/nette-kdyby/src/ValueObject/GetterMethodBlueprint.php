<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
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
    public function __construct(string $methodName, ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $returnTypeNode, string $variableName)
    {
        $this->methodName = $methodName;
        $this->returnTypeNode = $returnTypeNode;
        $this->variableName = $variableName;
    }
    public function getMethodName() : string
    {
        return $this->methodName;
    }
    public function getReturnTypeNode() : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        return $this->returnTypeNode;
    }
    public function getVariableName() : string
    {
        return $this->variableName;
    }
}
