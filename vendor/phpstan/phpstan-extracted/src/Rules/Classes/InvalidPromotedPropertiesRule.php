<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Classes;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Php\PhpVersion;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Rule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node>
 */
class InvalidPromotedPropertiesRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrowFunction && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_) {
            return [];
        }
        $hasPromotedProperties = \false;
        foreach ($node->params as $param) {
            if ($param->flags === 0) {
                continue;
            }
            $hasPromotedProperties = \true;
            break;
        }
        if (!$hasPromotedProperties) {
            return [];
        }
        if (!$this->phpVersion->supportsPromotedProperties()) {
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message('Promoted properties are supported only on PHP 8.0 and later.')->nonIgnorable()->build()];
        }
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod || $node->name->toLowerString() !== '__construct') {
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message('Promoted properties can be in constructor only.')->nonIgnorable()->build()];
        }
        if ($node->stmts === null) {
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message('Promoted properties are not allowed in abstract constructors.')->nonIgnorable()->build()];
        }
        $errors = [];
        foreach ($node->params as $param) {
            if ($param->flags === 0) {
                continue;
            }
            if (!$param->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable || !\is_string($param->var->name)) {
                throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
            }
            if (!$param->variadic) {
                continue;
            }
            $propertyName = $param->var->name;
            $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Promoted property parameter $%s can not be variadic.', $propertyName))->nonIgnorable()->line($param->getLine())->build();
            continue;
        }
        return $errors;
    }
}
