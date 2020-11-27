<?php

declare (strict_types=1);
namespace PHPStan\Reflection\SignatureMap;

use _PhpScoper26e51eeacccf\Nette\Schema\Expect;
use _PhpScoper26e51eeacccf\Nette\Schema\Processor;
use PHPStan\Testing\TestCase;
class FunctionMetadataTest extends \PHPStan\Testing\TestCase
{
    public function testSchema() : void
    {
        $data = (require __DIR__ . '/../../../../resources/functionMetadata.php');
        $this->assertIsArray($data);
        $processor = new \_PhpScoper26e51eeacccf\Nette\Schema\Processor();
        $processor->process(\_PhpScoper26e51eeacccf\Nette\Schema\Expect::arrayOf(\_PhpScoper26e51eeacccf\Nette\Schema\Expect::structure(['hasSideEffects' => \_PhpScoper26e51eeacccf\Nette\Schema\Expect::bool()->required()])->required())->required(), $data);
    }
}
