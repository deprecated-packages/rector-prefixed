<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractKdybyEventSubscriberRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    protected function shouldSkipClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $classLike = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \true;
        }
        if (!$this->isObjectType($classLike, '_PhpScopere8e811afab72\\Kdyby\\Events\\Subscriber')) {
            return \true;
        }
        return !$this->isName($classMethod, 'getSubscribedEvents');
    }
}
