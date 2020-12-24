<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\SymfonyPHPUnit\Naming;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\PropertyNaming;
final class ServiceNaming
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyNaming = $propertyNaming;
    }
    public function resolvePropertyNameFromServiceType(string $serviceType) : string
    {
        if (\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::contains($serviceType, '_') && !\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::contains($serviceType, '\\')) {
            return $this->propertyNaming->underscoreToName($serviceType);
        }
        return $this->propertyNaming->fqnToVariableName(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($serviceType));
    }
}
