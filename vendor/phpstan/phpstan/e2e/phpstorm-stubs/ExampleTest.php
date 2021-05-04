<?php

namespace RectorPrefix20210504\PHPStanE2EJetbrainsPhpStormStubs;

require_once __DIR__ . '/../../vendor/autoload.php';
use PhpParser\Node\Stmt\Echo_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
class ExampleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new class($this->createReflectionProvider()) implements \PHPStan\Rules\Rule
        {
            /** @var ReflectionProvider */
            private $reflectionProvider;
            public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
            {
                $this->reflectionProvider = $reflectionProvider;
            }
            /**
             * @return string
             */
            public function getNodeType() : string
            {
                return \PhpParser\Node\Stmt\Echo_::class;
            }
            public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
            {
                $this->reflectionProvider->getClass('LevelDBWriteBatch');
                return [\sprintf('Echo: %s', $node->exprs[0]->value)];
            }
        };
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/test.php'], [['Echo: ok', 3]]);
    }
}
