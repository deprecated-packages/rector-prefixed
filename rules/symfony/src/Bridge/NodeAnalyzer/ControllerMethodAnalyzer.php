<?php

declare (strict_types=1);
namespace Rector\Symfony\Bridge\NodeAnalyzer;

use RectorPrefix20210216\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class ControllerMethodAnalyzer
{
    /**
     * Detect if is <some>Action() in Controller
     */
    public function isAction(\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        $parentClassName = (string) $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if (\RectorPrefix20210216\Nette\Utils\Strings::endsWith($parentClassName, 'Controller')) {
            return \true;
        }
        if (\RectorPrefix20210216\Nette\Utils\Strings::endsWith((string) $node->name, 'Action')) {
            return \true;
        }
        return $node->isPublic();
    }
}
