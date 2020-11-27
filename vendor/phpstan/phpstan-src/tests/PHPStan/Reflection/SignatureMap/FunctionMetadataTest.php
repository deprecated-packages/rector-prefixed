<?php

declare (strict_types=1);
namespace PHPStan\Reflection\SignatureMap;

use _PhpScopera143bcca66cb\Nette\Schema\Expect;
use _PhpScopera143bcca66cb\Nette\Schema\Processor;
use PHPStan\Testing\TestCase;
class FunctionMetadataTest extends \PHPStan\Testing\TestCase
{
    public function testSchema() : void
    {
        $data = (require __DIR__ . '/../../../../resources/functionMetadata.php');
        $this->assertIsArray($data);
        $processor = new \_PhpScopera143bcca66cb\Nette\Schema\Processor();
        $processor->process(\_PhpScopera143bcca66cb\Nette\Schema\Expect::arrayOf(\_PhpScopera143bcca66cb\Nette\Schema\Expect::structure(['hasSideEffects' => \_PhpScopera143bcca66cb\Nette\Schema\Expect::bool()->required()])->required())->required(), $data);
    }
}
