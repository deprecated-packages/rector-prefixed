<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Symfony\Bridge\NodeAnalyzer;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class ControllerMethodAnalyzer
{
    /**
     * Detect if is <some>Action() in Controller
     */
    public function isAction(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        $parentClassName = (string) $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::endsWith($parentClassName, 'Controller')) {
            return \true;
        }
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::endsWith((string) $node->name, 'Action')) {
            return \true;
        }
        return $node->isPublic();
    }
}
