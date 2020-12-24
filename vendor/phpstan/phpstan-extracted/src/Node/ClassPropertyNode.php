<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType;
use _PhpScopere8e811afab72\PhpParser\NodeAbstract;
class ClassPropertyNode extends \_PhpScopere8e811afab72\PhpParser\NodeAbstract implements \_PhpScopere8e811afab72\PHPStan\Node\VirtualNode
{
    /** @var string */
    private $name;
    /** @var int */
    private $flags;
    /** @var Identifier|Name|NullableType|UnionType|null */
    private $type;
    /** @var Expr|null */
    private $default;
    /** @var string|null */
    private $phpDoc;
    /** @var bool */
    private $isPromoted;
    /**
     * @param int $flags
     * @param Identifier|Name|NullableType|UnionType|null $type
     * @param string $name
     * @param Expr|null $default
     */
    public function __construct(string $name, int $flags, $type, ?\_PhpScopere8e811afab72\PhpParser\Node\Expr $default, ?string $phpDoc, bool $isPromoted, \_PhpScopere8e811afab72\PhpParser\Node $originalNode)
    {
        parent::__construct($originalNode->getAttributes());
        $this->name = $name;
        $this->flags = $flags;
        $this->type = $type;
        $this->default = $default;
        $this->isPromoted = $isPromoted;
        $this->phpDoc = $phpDoc;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getFlags() : int
    {
        return $this->flags;
    }
    public function getDefault() : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->default;
    }
    public function isPromoted() : bool
    {
        return $this->isPromoted;
    }
    public function getPhpDoc() : ?string
    {
        return $this->phpDoc;
    }
    public function isPublic() : bool
    {
        return ($this->flags & \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC) !== 0 || ($this->flags & \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::VISIBILITY_MODIFIER_MASK) === 0;
    }
    public function isProtected() : bool
    {
        return (bool) ($this->flags & \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::MODIFIER_PROTECTED);
    }
    public function isPrivate() : bool
    {
        return (bool) ($this->flags & \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE);
    }
    public function isStatic() : bool
    {
        return (bool) ($this->flags & \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::MODIFIER_STATIC);
    }
    /**
     * @return Identifier|Name|NullableType|UnionType|null
     */
    public function getNativeType()
    {
        return $this->type;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_ClassPropertyNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
