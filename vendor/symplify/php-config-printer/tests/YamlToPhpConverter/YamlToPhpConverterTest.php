<?php

declare (strict_types=1);
namespace RectorPrefix20210312\Symplify\PhpConfigPrinter\Tests\YamlToPhpConverter;

use RectorPrefix20210312\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210312\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel;
use RectorPrefix20210312\Symplify\PhpConfigPrinter\YamlToPhpConverter;
final class YamlToPhpConverterTest extends \RectorPrefix20210312\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var YamlToPhpConverter
     */
    private $yamlToPhpConverter;
    protected function setUp() : void
    {
        $this->bootKernel(\RectorPrefix20210312\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel::class);
        $this->yamlToPhpConverter = $this->getService(\RectorPrefix20210312\Symplify\PhpConfigPrinter\YamlToPhpConverter::class);
    }
    public function test() : void
    {
        $printedPhpConfigContent = $this->yamlToPhpConverter->convertYamlArray(['parameters' => ['key' => 'value']]);
        $this->assertStringEqualsFile(__DIR__ . '/Fixture/expected_parameters.php', $printedPhpConfigContent);
    }
}
