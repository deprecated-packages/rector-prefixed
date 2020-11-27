<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter;

use Iterator;
use PHPStan\Type\IntegerType;
use PHPStan\Type\StringType;
use PHPStan\Type\UnionType;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel;
use Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
use Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\ClassWithConstants;
use Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\ClassWithType;
use Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\FirstClass;
use Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\SecondClass;
use Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\ValueObject\Simple;
final class SmartPhpConfigPrinterTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var SmartPhpConfigPrinter
     */
    private $smartPhpConfigPrinter;
    protected function setUp() : void
    {
        $this->bootKernel(\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel::class);
        $this->smartPhpConfigPrinter = self::$container->get(\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(array $services, string $expectedContentFilePath) : void
    {
        $printedContent = $this->smartPhpConfigPrinter->printConfiguredServices($services);
        $this->assertStringEqualsFile($expectedContentFilePath, $printedContent, $expectedContentFilePath);
    }
    public function provideData() : \Iterator
    {
        (yield [[\Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\FirstClass::class => ['some_key' => 'some_value'], \Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\SecondClass::class => null], __DIR__ . '/Fixture/expected_file.php.inc']);
        (yield [[\Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\ClassWithConstants::class => [\Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\ClassWithConstants::CONFIG_KEY => 'it is constant', \Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\ClassWithConstants::NUMERIC_CONFIG_KEY => 'a lot of numbers']], __DIR__ . '/Fixture/expected_constant_file.php.inc']);
        (yield [[\Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\SecondClass::class => ['some_key' => new \Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\ValueObject\Simple('Steve')]], __DIR__ . '/Fixture/expected_value_object_file.php.inc']);
        (yield [[\Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\SecondClass::class => ['some_key' => [new \Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\ValueObject\Simple('Paul')]]], __DIR__ . '/Fixture/expected_value_objects_file.php.inc']);
        (yield [[\Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\SecondClass::class => ['some_key' => [new \Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\ClassWithType(new \PHPStan\Type\StringType())]]], __DIR__ . '/Fixture/expected_value_nested_objects.php.inc']);
        $unionType = new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()]);
        (yield [[\Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\SecondClass::class => ['some_key' => [new \Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\ClassWithType($unionType)]]], __DIR__ . '/Fixture/expected_value_nested_union_objects.php.inc']);
    }
}
