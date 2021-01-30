<?php

declare (strict_types=1);
namespace RectorPrefix20210130\Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source;

use PHPStan\Type\Type;
final class ClassWithType
{
    /**
     * @var Type
     */
    private $type;
    public function __construct(\PHPStan\Type\Type $type)
    {
        $this->type = $type;
    }
    public function getType() : \PHPStan\Type\Type
    {
        return $this->type;
    }
}
