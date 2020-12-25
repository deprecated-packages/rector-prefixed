<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection;

use PhpParser\Lexer\Emulative;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator as AstLocator;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Parser\MemoizingParser;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\AggregateSourceStubber;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AutoloadSourceLocator;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\FindReflectionOnLine;
use const PHP_VERSION_ID;
final class BetterReflection
{
    /** @var int */
    public static $phpVersion = \PHP_VERSION_ID;
    /** @var SourceLocator|null */
    private static $sharedSourceLocator;
    /** @var SourceLocator|null */
    private $sourceLocator;
    /** @var ClassReflector|null */
    private static $sharedClassReflector;
    /** @var ClassReflector|null */
    private $classReflector;
    /** @var FunctionReflector|null */
    private static $sharedFunctionReflector;
    /** @var FunctionReflector|null */
    private $functionReflector;
    /** @var ConstantReflector|null */
    private static $sharedConstantReflector;
    /** @var ConstantReflector|null */
    private $constantReflector;
    /** @var Parser|null */
    private static $sharedPhpParser;
    /** @var Parser|null */
    private $phpParser;
    /** @var SourceStubber|null */
    private static $sharedSourceStubber;
    /** @var SourceStubber|null */
    private $sourceStubber;
    /** @var AstLocator|null */
    private $astLocator;
    /** @var FindReflectionOnLine|null */
    private $findReflectionOnLine;
    public static function populate(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector $classReflector, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector $constantReflector, \PhpParser\Parser $phpParser, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber $sourceStubber) : void
    {
        self::$sharedSourceLocator = $sourceLocator;
        self::$sharedClassReflector = $classReflector;
        self::$sharedFunctionReflector = $functionReflector;
        self::$sharedConstantReflector = $constantReflector;
        self::$sharedPhpParser = $phpParser;
        self::$sharedSourceStubber = $sourceStubber;
    }
    public function __construct()
    {
        $this->sourceLocator = self::$sharedSourceLocator;
        $this->classReflector = self::$sharedClassReflector;
        $this->functionReflector = self::$sharedFunctionReflector;
        $this->constantReflector = self::$sharedConstantReflector;
        $this->phpParser = self::$sharedPhpParser;
        $this->sourceStubber = self::$sharedSourceStubber;
    }
    public function sourceLocator() : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator
    {
        $astLocator = $this->astLocator();
        $sourceStubber = $this->sourceStubber();
        return $this->sourceLocator ?? ($this->sourceLocator = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator([new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $sourceStubber), new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator($astLocator, $sourceStubber), new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AutoloadSourceLocator($astLocator, $this->phpParser())])));
    }
    public function classReflector() : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector
    {
        return $this->classReflector ?? ($this->classReflector = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector($this->sourceLocator()));
    }
    public function functionReflector() : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector
    {
        return $this->functionReflector ?? ($this->functionReflector = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector($this->sourceLocator(), $this->classReflector()));
    }
    public function constantReflector() : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector
    {
        return $this->constantReflector ?? ($this->constantReflector = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector($this->sourceLocator(), $this->classReflector()));
    }
    public function phpParser() : \PhpParser\Parser
    {
        return $this->phpParser ?? ($this->phpParser = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Parser\MemoizingParser((new \PhpParser\ParserFactory())->create(\PhpParser\ParserFactory::PREFER_PHP7, new \PhpParser\Lexer\Emulative(['usedAttributes' => ['comments', 'startLine', 'endLine', 'startFilePos', 'endFilePos']]))));
    }
    public function astLocator() : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator
    {
        return $this->astLocator ?? ($this->astLocator = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator($this->phpParser(), function () : FunctionReflector {
            return $this->functionReflector();
        }));
    }
    public function findReflectionsOnLine() : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\FindReflectionOnLine
    {
        return $this->findReflectionOnLine ?? ($this->findReflectionOnLine = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\FindReflectionOnLine($this->sourceLocator(), $this->astLocator()));
    }
    public function sourceStubber() : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber
    {
        return $this->sourceStubber ?? ($this->sourceStubber = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\AggregateSourceStubber(new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber($this->phpParser(), self::$phpVersion), new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber()));
    }
}
