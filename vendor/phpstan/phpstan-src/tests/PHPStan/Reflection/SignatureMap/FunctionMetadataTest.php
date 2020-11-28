<?php

declare (strict_types=1);
namespace PHPStan\Reflection\SignatureMap;

use _PhpScoperabd03f0baf05\Nette\Schema\Expect;
use _PhpScoperabd03f0baf05\Nette\Schema\Processor;
use PHPStan\Testing\TestCase;
class FunctionMetadataTest extends \PHPStan\Testing\TestCase
{
    public function testSchema() : void
    {
        $data = (require __DIR__ . '/../../../../resources/functionMetadata.php');
        $this->assertIsArray($data);
        $processor = new \_PhpScoperabd03f0baf05\Nette\Schema\Processor();
        $processor->process(\_PhpScoperabd03f0baf05\Nette\Schema\Expect::arrayOf(\_PhpScoperabd03f0baf05\Nette\Schema\Expect::structure(['hasSideEffects' => \_PhpScoperabd03f0baf05\Nette\Schema\Expect::bool()->required()])->required())->required(), $data);
    }
}
