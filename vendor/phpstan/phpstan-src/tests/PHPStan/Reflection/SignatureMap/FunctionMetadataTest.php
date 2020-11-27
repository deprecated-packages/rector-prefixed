<?php

declare (strict_types=1);
namespace PHPStan\Reflection\SignatureMap;

use _PhpScoperbd5d0c5f7638\Nette\Schema\Expect;
use _PhpScoperbd5d0c5f7638\Nette\Schema\Processor;
use PHPStan\Testing\TestCase;
class FunctionMetadataTest extends \PHPStan\Testing\TestCase
{
    public function testSchema() : void
    {
        $data = (require __DIR__ . '/../../../../resources/functionMetadata.php');
        $this->assertIsArray($data);
        $processor = new \_PhpScoperbd5d0c5f7638\Nette\Schema\Processor();
        $processor->process(\_PhpScoperbd5d0c5f7638\Nette\Schema\Expect::arrayOf(\_PhpScoperbd5d0c5f7638\Nette\Schema\Expect::structure(['hasSideEffects' => \_PhpScoperbd5d0c5f7638\Nette\Schema\Expect::bool()->required()])->required())->required(), $data);
    }
}
