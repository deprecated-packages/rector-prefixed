<?php

declare (strict_types=1);
namespace Rector\NetteKdyby\Rector\ClassMethod;

use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractKdybyEventSubscriberRector extends \Rector\Core\Rector\AbstractRector
{
    protected function shouldSkipClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $classLike = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \true;
        }
        if (!$this->isObjectType($classLike, '_PhpScoper267b3276efc2\\Kdyby\\Events\\Subscriber')) {
            return \true;
        }
        return !$this->isName($classMethod, 'getSubscribedEvents');
    }
}
