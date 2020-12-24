<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\NamingConvention;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
final class NamingConventionAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * Matches cases:
     *
     * $someNameSuffix = $this->getSomeName();
     * $prefixSomeName = $this->getSomeName();
     * $someName = $this->getSomeName();
     *
     * @param FuncCall|StaticCall|MethodCall $expr
     */
    public function isCallMatchingVariableName(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr, string $currentName, string $expectedName) : bool
    {
        // skip "$call = $method->call();" based conventions
        $callName = $this->nodeNameResolver->getName($expr->name);
        if ($currentName === $callName) {
            return \true;
        }
        // starts with or ends with
        return (bool) \_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($currentName, '#^(' . $expectedName . '|' . $expectedName . '$)#i');
    }
}
