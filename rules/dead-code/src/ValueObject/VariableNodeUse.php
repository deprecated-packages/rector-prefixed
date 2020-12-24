<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class VariableNodeUse
{
    /**
     * @var string
     */
    public const TYPE_USE = 'use';
    /**
     * @var string
     */
    public const TYPE_ASSIGN = 'assign';
    /**
     * @var int
     */
    private $startTokenPosition;
    /**
     * @var string
     */
    private $variableName;
    /**
     * @var string
     */
    private $type;
    /**
     * @var Variable
     */
    private $variable;
    /**
     * @var string|null
     */
    private $nestingHash;
    public function __construct(int $startTokenPosition, string $variableName, string $type, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable, ?string $nestingHash = null)
    {
        $this->startTokenPosition = $startTokenPosition;
        $this->variableName = $variableName;
        $this->type = $type;
        $this->variable = $variable;
        $this->nestingHash = $nestingHash;
    }
    public function isName(string $name) : bool
    {
        return $this->variableName === $name;
    }
    public function getStartTokenPosition() : int
    {
        return $this->startTokenPosition;
    }
    public function isType(string $type) : bool
    {
        return $this->type === $type;
    }
    public function getVariableNode() : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        return $this->variable;
    }
    public function getParentNode() : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $parentNode = $this->variable->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $parentNode;
    }
    public function getNestingHash() : ?string
    {
        return $this->nestingHash;
    }
}
