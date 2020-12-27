<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper\Contract\PhpDocParser;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\NameScope;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\Type;
interface PhpDocTypeMapperInterface
{
    public function getNodeType() : string;
    public function mapToPHPStanType(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\NameScope $nameScope) : \PHPStan\Type\Type;
}
