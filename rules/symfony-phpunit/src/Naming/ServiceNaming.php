<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\SymfonyPHPUnit\Naming;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming;
final class ServiceNaming
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->propertyNaming = $propertyNaming;
    }
    public function resolvePropertyNameFromServiceType(string $serviceType) : string
    {
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($serviceType, '_') && !\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($serviceType, '\\')) {
            return $this->propertyNaming->underscoreToName($serviceType);
        }
        return $this->propertyNaming->fqnToVariableName(new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($serviceType));
    }
}
