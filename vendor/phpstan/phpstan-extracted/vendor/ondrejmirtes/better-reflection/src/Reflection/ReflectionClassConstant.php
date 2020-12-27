<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection;

use PhpParser\Node\Stmt\ClassConst;
use ReflectionProperty;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompileNodeToValue;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompilerContext;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\StringCast\ReflectionClassConstantStringCast;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\CalculateReflectionColum;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\GetLastDocComment;
class ReflectionClassConstant
{
    /** @var bool */
    private $valueWasCached = \false;
    /** @var scalar|array<scalar>|null const value */
    private $value;
    /** @var Reflector */
    private $reflector;
    /** @var ReflectionClass Constant owner */
    private $owner;
    /** @var ClassConst */
    private $node;
    /** @var int */
    private $positionInNode;
    private function __construct()
    {
    }
    /**
     * Create a reflection of a class's constant by Const Node
     *
     * @internal
     *
     * @param ClassConst $node Node has to be processed by the PhpParser\NodeVisitor\NameResolver
     */
    public static function createFromNode(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \PhpParser\Node\Stmt\ClassConst $node, int $positionInNode, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $owner) : self
    {
        $ref = new self();
        $ref->node = $node;
        $ref->positionInNode = $positionInNode;
        $ref->owner = $owner;
        $ref->reflector = $reflector;
        return $ref;
    }
    /**
     * Get the name of the reflection (e.g. if this is a ReflectionClass this
     * will be the class name).
     */
    public function getName() : string
    {
        return $this->node->consts[$this->positionInNode]->name->name;
    }
    /**
     * Returns constant value
     *
     * @return scalar|array<scalar>|null
     */
    public function getValue()
    {
        if ($this->valueWasCached !== \false) {
            return $this->value;
        }
        $this->value = (new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompileNodeToValue())->__invoke($this->node->consts[$this->positionInNode]->value, new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompilerContext($this->reflector, $this->owner->getFileName(), $this->getDeclaringClass(), $this->owner->getNamespaceName(), null));
        $this->valueWasCached = \true;
        return $this->value;
    }
    /**
     * Constant is public
     */
    public function isPublic() : bool
    {
        return $this->node->isPublic();
    }
    /**
     * Constant is private
     */
    public function isPrivate() : bool
    {
        return $this->node->isPrivate();
    }
    /**
     * Constant is protected
     */
    public function isProtected() : bool
    {
        return $this->node->isProtected();
    }
    /**
     * Returns a bitfield of the access modifiers for this constant
     */
    public function getModifiers() : int
    {
        $val = 0;
        $val += $this->isPublic() ? \ReflectionProperty::IS_PUBLIC : 0;
        $val += $this->isProtected() ? \ReflectionProperty::IS_PROTECTED : 0;
        $val += $this->isPrivate() ? \ReflectionProperty::IS_PRIVATE : 0;
        return $val;
    }
    /**
     * Get the line number that this constant starts on.
     */
    public function getStartLine() : int
    {
        return $this->node->getStartLine();
    }
    /**
     * Get the line number that this constant ends on.
     */
    public function getEndLine() : int
    {
        return $this->node->getEndLine();
    }
    public function getStartColumn() : int
    {
        return \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\CalculateReflectionColum::getStartColumn($this->owner->getLocatedSource()->getSource(), $this->node);
    }
    public function getEndColumn() : int
    {
        return \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\CalculateReflectionColum::getEndColumn($this->owner->getLocatedSource()->getSource(), $this->node);
    }
    /**
     * Get the declaring class
     */
    public function getDeclaringClass() : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass
    {
        return $this->owner;
    }
    /**
     * Returns the doc comment for this constant
     */
    public function getDocComment() : string
    {
        return \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\GetLastDocComment::forNode($this->node);
    }
    public function __toString() : string
    {
        return \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\StringCast\ReflectionClassConstantStringCast::toString($this);
    }
    public function getAst() : \PhpParser\Node\Stmt\ClassConst
    {
        return $this->node;
    }
    public function getPositionInAst() : int
    {
        return $this->positionInNode;
    }
}
