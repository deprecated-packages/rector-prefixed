<?php

declare (strict_types=1);
namespace Rector\SymfonyPHPUnit\Naming;

use _PhpScoper006a73f0e455\Nette\Utils\Strings;
use PHPStan\Type\ObjectType;
use Rector\Naming\Naming\PropertyNaming;
final class ServiceNaming
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyNaming = $propertyNaming;
    }
    public function resolvePropertyNameFromServiceType(string $serviceType) : string
    {
        if (\_PhpScoper006a73f0e455\Nette\Utils\Strings::contains($serviceType, '_') && !\_PhpScoper006a73f0e455\Nette\Utils\Strings::contains($serviceType, '\\')) {
            return $this->propertyNaming->underscoreToName($serviceType);
        }
        return $this->propertyNaming->fqnToVariableName(new \PHPStan\Type\ObjectType($serviceType));
    }
}
