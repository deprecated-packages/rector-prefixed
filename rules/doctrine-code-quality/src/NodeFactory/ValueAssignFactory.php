<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DoctrineCodeQuality\NodeFactory;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
final class ValueAssignFactory
{
    public function createDefaultDateTimeAssign(string $propertyName) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression
    {
        $propertyFetch = $this->createPropertyFetch($propertyName);
        $assign = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($propertyFetch, $this->createNewDateTime());
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression($assign);
    }
    public function createDefaultDateTimeWithValueAssign(string $propertyName, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $defaultExpr) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression
    {
        $propertyFetch = $this->createPropertyFetch($propertyName);
        $newDateTime = $this->createNewDateTime();
        $this->addDateTimeArgumentIfNotDefault($defaultExpr, $newDateTime);
        $assign = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($propertyFetch, $newDateTime);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression($assign);
    }
    private function createPropertyFetch(string $propertyName) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch
    {
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('this'), $propertyName);
    }
    private function createNewDateTime() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_
    {
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified('DateTime'));
    }
    private function addDateTimeArgumentIfNotDefault(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $defaultExpr, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_ $dateTimeNew) : void
    {
        if ($defaultExpr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_ && ($defaultExpr->value === 'now' || $defaultExpr->value === 'now()')) {
            return;
        }
        $dateTimeNew->args[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($defaultExpr);
    }
}
