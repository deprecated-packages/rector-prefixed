<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Tests\Naming;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming;
use _PhpScoperb75b35f52b74\Rector\Naming\ValueObject\ExpectedName;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class PropertyNamingTest extends \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel::class);
        $this->propertyNaming = $this->getService(\_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming::class);
    }
    /**
     * @dataProvider getExpectedNameFromMethodNameDataProvider
     */
    public function testGetExpectedNameFromMethodName(string $methodName, ?string $expectedPropertyName) : void
    {
        /** @var ExpectedName $actualPropertyName */
        $actualPropertyName = $this->propertyNaming->getExpectedNameFromMethodName($methodName);
        if ($expectedPropertyName === null) {
            $this->assertNull($actualPropertyName);
        } else {
            $this->assertSame($expectedPropertyName, $actualPropertyName->getSingularized());
        }
    }
    public function getExpectedNameFromMethodNameDataProvider() : \Iterator
    {
        (yield ['getMethods', 'method']);
        (yield ['getUsedTraits', 'usedTrait']);
        (yield ['getPackagesData', 'packageData']);
        (yield ['getPackagesInfo', 'packageInfo']);
        (yield ['getAnythingElseData', 'anythingElseData']);
        (yield ['getAnythingElseInfo', 'anythingElseInfo']);
        (yield ['getSpaceshipsInfo', 'spaceshipInfo']);
        (yield ['resolveDependencies', null]);
    }
}
