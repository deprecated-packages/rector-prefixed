<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PSR4\Tests\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector\Source;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface;
final class DummyPSR4AutoloadWithoutNamespaceMatcher implements \_PhpScoperb75b35f52b74\Rector\PSR4\Contract\PSR4AutoloadNamespaceMatcherInterface
{
    public function getExpectedNamespace(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        return '_PhpScoperb75b35f52b74\\Rector\\PSR4\\Tests\\Rector\\FileWithoutNamespace\\NormalizeNamespaceByPSR4ComposerAutoloadRector\\Fixture';
    }
}
