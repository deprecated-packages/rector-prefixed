<?php

declare(strict_types=1);

namespace Rector\Nette\Kdyby\ValueObject;

use PhpParser\Node;

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

    /**
     * @param \PhpParser\Node|null $returnTypeNode
     */
    public function __construct(string $methodName, $returnTypeNode, string $variableName)
    {
        $this->methodName = $methodName;
        $this->returnTypeNode = $returnTypeNode;
        $this->variableName = $variableName;
    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return \PhpParser\Node|null
     */
    public function getReturnTypeNode()
    {
        return $this->returnTypeNode;
    }

    public function getVariableName(): string
    {
        return $this->variableName;
    }
}
