<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteKdyby\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
abstract class AbstractKdybyEventSubscriberRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    protected function shouldSkipClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $classLike = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \true;
        }
        if (!$this->isObjectType($classLike, '_PhpScoperb75b35f52b74\\Kdyby\\Events\\Subscriber')) {
            return \true;
        }
        return !$this->isName($classMethod, 'getSubscribedEvents');
    }
}
