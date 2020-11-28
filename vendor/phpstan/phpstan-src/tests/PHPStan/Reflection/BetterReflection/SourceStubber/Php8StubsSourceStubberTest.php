<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection\SourceStubber;

use PhpParser\Lexer\Emulative;
use PhpParser\ParserFactory;
use _PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
class Php8StubsSourceStubberTest extends \_PhpScoperabd03f0baf05\PHPUnit\Framework\TestCase
{
    public function testClass() : void
    {
        /** @var ClassReflector $classReflector */
        [$classReflector] = $this->getReflectors();
        $reflection = $classReflector->reflect(\Throwable::class);
        $this->assertSame(\Throwable::class, $reflection->getName());
    }
    public function testFunction() : void
    {
        /** @var FunctionReflector $functionReflector */
        [, $functionReflector] = $this->getReflectors();
        $reflection = $functionReflector->reflect('htmlspecialchars');
        $this->assertSame('htmlspecialchars', $reflection->getName());
    }
    /**
     * @return array{ClassReflector, FunctionReflector}
     */
    private function getReflectors() : array
    {
        // memoizing parser screws things up so we need to create the universe from the start
        $parser = (new \PhpParser\ParserFactory())->create(\PhpParser\ParserFactory::PREFER_PHP7, new \PhpParser\Lexer\Emulative(['usedAttributes' => ['comments', 'startLine', 'endLine', 'startFilePos', 'endFilePos']]));
        /** @var FunctionReflector $functionReflector */
        $functionReflector = null;
        $astLocator = new \_PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Ast\Locator($parser, static function () use(&$functionReflector) : FunctionReflector {
            return $functionReflector;
        });
        $sourceStubber = new \PHPStan\Reflection\BetterReflection\SourceStubber\Php8StubsSourceStubber();
        $phpInternalSourceLocator = new \_PhpScoperabd03f0baf05\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $sourceStubber);
        $classReflector = new \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\ClassReflector($phpInternalSourceLocator);
        $functionReflector = new \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\FunctionReflector($phpInternalSourceLocator, $classReflector);
        return [$classReflector, $functionReflector];
    }
}
