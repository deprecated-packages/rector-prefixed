<?php

declare (strict_types=1);
namespace RectorPrefix20210407\Symplify\PackageBuilder\Tests\Composer;

use RectorPrefix20210407\PHPUnit\Framework\TestCase;
use RectorPrefix20210407\Symplify\PackageBuilder\Composer\VendorDirProvider;
final class VendorDirProviderTest extends \RectorPrefix20210407\PHPUnit\Framework\TestCase
{
    public function testProvide() : void
    {
        $vendorDirProvider = new \RectorPrefix20210407\Symplify\PackageBuilder\Composer\VendorDirProvider();
        $this->assertStringEndsWith('vendor', $vendorDirProvider->provide());
        $this->assertFileExists($vendorDirProvider->provide() . '/autoload.php');
    }
}
