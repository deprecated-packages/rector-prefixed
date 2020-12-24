<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony\Bridge\NodeAnalyzer;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class ControllerMethodAnalyzer
{
    /**
     * Detect if is <some>Action() in Controller
     */
    public function isAction(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        $parentClassName = (string) $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($parentClassName, 'Controller')) {
            return \true;
        }
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith((string) $node->name, 'Action')) {
            return \true;
        }
        return $node->isPublic();
    }
}
