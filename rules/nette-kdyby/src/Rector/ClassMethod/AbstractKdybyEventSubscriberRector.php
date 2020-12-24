<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteKdyby\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractKdybyEventSubscriberRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    protected function shouldSkipClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $classLike = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \true;
        }
        if (!$this->isObjectType($classLike, '_PhpScoper0a6b37af0871\\Kdyby\\Events\\Subscriber')) {
            return \true;
        }
        return !$this->isName($classMethod, 'getSubscribedEvents');
    }
}
