<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Source;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface;
final class DummyPSR4AutoloadWithoutNamespaceMatcher implements \_PhpScopere8e811afab72\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface
{
    public function getExpectedNamespace(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        return '_PhpScopere8e811afab72\\Rector\\PSR4\\Tests\\Rector\\FileWithoutNamespace\\NormalizeNamespaceByPSR4ComposerAutoloadRector\\Fixture';
    }
}
