<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\ValueObject\ArrayCallable;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class ArrayCallableMethodReferenceAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * Matches array like: "[$this, 'methodName']" → ['ClassName', 'methodName']
     */
    public function match(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_ $array) : ?\_PhpScoper0a6b37af0871\Rector\NodeCollector\ValueObject\ArrayCallable
    {
        $arrayItems = (array) $array->items;
        if (\count($arrayItems) !== 2) {
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
        if (!$array->items[1]->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            return null;
        }
        /** @var String_ $string */
        $string = $array->items[1]->value;
        $methodName = $string->value;
        $className = $array->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return null;
        }
        return new \_PhpScoper0a6b37af0871\Rector\NodeCollector\ValueObject\ArrayCallable($className, $methodName);
    }
    private function isThisVariable(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : bool
    {
        // $this
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable && $this->nodeNameResolver->isName($expr, 'this')) {
            return \true;
        }
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch) {
            if (!$this->nodeNameResolver->isName($expr->name, 'class')) {
                return \false;
            }
            // self::class, static::class
            if ($this->nodeNameResolver->isNames($expr->class, ['self', 'static'])) {
                return \true;
            }
            /** @var string|null $className */
            $className = $expr->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($className === null) {
                return \false;
            }
            return $this->nodeNameResolver->isName($expr->class, $className);
        }
        return \false;
    }
}
