<?php

declare (strict_types=1);
namespace Rector\NodeCollector\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use Rector\NodeCollector\ValueObject\ArrayCallable;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class ArrayCallableMethodReferenceAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * Matches array like: "[$this, 'methodName']" → ['ClassName', 'methodName']
     */
    public function match(\PhpParser\Node\Expr\Array_ $array) : ?\Rector\NodeCollector\ValueObject\ArrayCallable
    {
        if (\count($array->items) !== 2) {
            return null;
        }
        if ($array->items[0] === null) {
            return null;
        }
        if ($array->items[1] === null) {
            return null;
        }
        // $this, self, static, FQN
        if (!$this->isThisVariable($array->items[0]->value)) {
            return null;
        }
        if (!$array->items[1]->value instanceof \PhpParser\Node\Scalar\String_) {
            return null;
        }
        /** @var String_ $string */
        $string = $array->items[1]->value;
        $methodName = $string->value;
        $className = $array->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return null;
        }
        return new \Rector\NodeCollector\ValueObject\ArrayCallable($className, $methodName);
    }
    private function isThisVariable(\PhpParser\Node $node) : bool
    {
        // $this
        if ($node instanceof \PhpParser\Node\Expr\Variable && $this->nodeNameResolver->isName($node, 'this')) {
            return \true;
        }
        if ($node instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            if (!$this->nodeNameResolver->isName($node->name, 'class')) {
                return \false;
            }
            // self::class, static::class
            if ($this->nodeNameResolver->isNames($node->class, ['self', 'static'])) {
                return \true;
            }
            /** @var string|null $className */
            $className = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($className === null) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node->class, $className);
        }
        return \false;
    }
}
