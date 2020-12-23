<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteKdyby\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractKdybyEventSubscriberRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    protected function shouldSkipClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $classLike = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \true;
        }
        if (!$this->isObjectType($classLike, '_PhpScoper0a2ac50786fa\\Kdyby\\Events\\Subscriber')) {
            return \true;
        }
        return !$this->isName($classMethod, 'getSubscribedEvents');
    }
}
