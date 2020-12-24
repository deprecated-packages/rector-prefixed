<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\SymfonyPHPUnit\Naming;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\Rector\Naming\Naming\PropertyNaming;
final class ServiceNaming
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyNaming = $propertyNaming;
    }
    public function resolvePropertyNameFromServiceType(string $serviceType) : string
    {
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($serviceType, '_') && !\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($serviceType, '\\')) {
            return $this->propertyNaming->underscoreToName($serviceType);
        }
        return $this->propertyNaming->fqnToVariableName(new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($serviceType));
    }
}
