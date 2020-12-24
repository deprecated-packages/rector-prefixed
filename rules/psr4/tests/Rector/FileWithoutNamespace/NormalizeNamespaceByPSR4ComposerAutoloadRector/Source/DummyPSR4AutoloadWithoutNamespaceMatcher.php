<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Source;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface;
final class DummyPSR4AutoloadWithoutNamespaceMatcher implements \_PhpScoper0a6b37af0871\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface
{
    public function getExpectedNamespace(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?string
    {
        return '_PhpScoper0a6b37af0871\\Rector\\PSR4\\Tests\\Rector\\FileWithoutNamespace\\NormalizeNamespaceByPSR4ComposerAutoloadRector\\Fixture';
    }
}
