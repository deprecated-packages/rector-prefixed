<?php

declare (strict_types=1);
namespace PHPStan\Rules\Classes;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Php\PhpVersion;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node>
 */
class InvalidPromotedPropertiesRule implements \PHPStan\Rules\Rule
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \PhpParser\Node\Expr\ArrowFunction && !$node instanceof \PhpParser\Node\Stmt\ClassMethod && !$node instanceof \PhpParser\Node\Expr\Closure && !$node instanceof \PhpParser\Node\Stmt\Function_) {
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
            return [\PHPStan\Rules\RuleErrorBuilder::message('Promoted properties are supported only on PHP 8.0 and later.')->nonIgnorable()->build()];
        }
        if (!$node instanceof \PhpParser\Node\Stmt\ClassMethod || $node->name->toLowerString() !== '__construct') {
            return [\PHPStan\Rules\RuleErrorBuilder::message('Promoted properties can be in constructor only.')->nonIgnorable()->build()];
        }
        if ($node->stmts === null) {
            return [\PHPStan\Rules\RuleErrorBuilder::message('Promoted properties are not allowed in abstract constructors.')->nonIgnorable()->build()];
        }
        $errors = [];
        foreach ($node->params as $param) {
            if ($param->flags === 0) {
                continue;
            }
            if (!$param->var instanceof \PhpParser\Node\Expr\Variable || !\is_string($param->var->name)) {
                throw new \PHPStan\ShouldNotHappenException();
            }
            if (!$param->variadic) {
                continue;
            }
            $propertyName = $param->var->name;
            $errors[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Promoted property parameter $%s can not be variadic.', $propertyName))->nonIgnorable()->line($param->getLine())->build();
            continue;
        }
        return $errors;
    }
}
