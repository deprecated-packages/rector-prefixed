<?php

declare (strict_types=1);
namespace RectorPrefix20210321\Symplify\PackageBuilder\Tests\Composer;

use RectorPrefix20210321\PHPUnit\Framework\TestCase;
use RectorPrefix20210321\Symplify\PackageBuilder\Composer\VendorDirProvider;
final class VendorDirProviderTest extends \RectorPrefix20210321\PHPUnit\Framework\TestCase
{
    public function testProvide() : void
    {
        $vendorDirProvider = new \RectorPrefix20210321\Symplify\PackageBuilder\Composer\VendorDirProvider();
        $this->assertStringEndsWith('vendor', $vendorDirProvider->provide());
        $this->assertFileExists($vendorDirProvider->provide() . '/autoload.php');
    }
}
