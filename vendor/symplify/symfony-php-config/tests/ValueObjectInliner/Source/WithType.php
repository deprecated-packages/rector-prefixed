<?php

declare (strict_types=1);
namespace Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source;

use PHPStan\Type\Type;
final class WithType
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
