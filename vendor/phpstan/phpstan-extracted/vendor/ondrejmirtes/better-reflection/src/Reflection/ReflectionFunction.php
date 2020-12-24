<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection;

use Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike as FunctionNode;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_ as NamespaceNode;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\BetterReflection;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\Exception\NotImplemented;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\FunctionDoesNotExist;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\StringCast\ReflectionFunctionStringCast;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\ClosureSourceLocator;
use function function_exists;
class ReflectionFunction extends \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract implements \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
{
    /**
     * @throws IdentifierNotFound
     */
    public static function createFromName(string $functionName) : self
    {
        return (new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\BetterReflection())->functionReflector()->reflect($functionName);
    }
    /**
     * @throws IdentifierNotFound
     */
    public static function createFromClosure(\Closure $closure) : self
    {
        $configuration = new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\BetterReflection();
        return (new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector(new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\ClosureSourceLocator($closure, $configuration->phpParser()), $configuration->classReflector()))->reflect(self::CLOSURE_NAME);
    }
    public function __toString() : string
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\StringCast\ReflectionFunctionStringCast::toString($this);
    }
    /**
     * @internal
     *
     * @param Node\Stmt\ClassMethod|Node\Stmt\Function_|Node\Expr\Closure $node Node has to be processed by the PhpParser\NodeVisitor\NameResolver
     */
    public static function createFromNode(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $node, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_ $namespaceNode = null) : self
    {
        $function = new self();
        $function->populateFunctionAbstract($reflector, $node, $locatedSource, $namespaceNode);
        return $function;
    }
    /**
     * Check to see if this function has been disabled (by the PHP INI file
     * directive `disable_functions`).
     *
     * Note - we cannot reflect on internal functions (as there is no PHP source
     * code we can access. This means, at present, we can only EVER return false
     * from this function, because you cannot disable user-defined functions.
     *
     * @see https://php.net/manual/en/ini.core.php#ini.disable-functions
     *
     * @todo https://github.com/Roave/BetterReflection/issues/14
     */
    public function isDisabled() : bool
    {
        return \false;
    }
    /**
     * @throws NotImplemented
     * @throws FunctionDoesNotExist
     */
    public function getClosure() : \Closure
    {
        $this->assertIsNoClosure();
        $functionName = $this->getName();
        $this->assertFunctionExist($functionName);
        return static function (...$args) use($functionName) {
            return $functionName(...$args);
        };
    }
    /**
     * @param mixed ...$args
     *
     * @return mixed
     *
     * @throws NotImplemented
     * @throws FunctionDoesNotExist
     */
    public function invoke(...$args)
    {
        return $this->invokeArgs($args);
    }
    /**
     * @param mixed[] $args
     *
     * @return mixed
     *
     * @throws NotImplemented
     * @throws FunctionDoesNotExist
     */
    public function invokeArgs(array $args = [])
    {
        $this->assertIsNoClosure();
        $functionName = $this->getName();
        $this->assertFunctionExist($functionName);
        return $functionName(...$args);
    }
    /**
     * @throws NotImplemented
     */
    private function assertIsNoClosure() : void
    {
        if ($this->isClosure()) {
            throw new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Adapter\Exception\NotImplemented('Not implemented for closures');
        }
    }
    /**
     * @throws FunctionDoesNotExist
     *
     * @psalm-assert callable-string $functionName
     */
    private function assertFunctionExist(string $functionName) : void
    {
        if (!\function_exists($functionName)) {
            throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\FunctionDoesNotExist::fromName($functionName);
        }
    }
}
