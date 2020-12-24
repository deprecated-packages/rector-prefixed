<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpDocParser;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\NameScope;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface PhpDocTypeMapperInterface
{
    public function getNodeType() : string;
    public function mapToPHPStanType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\NameScope $nameScope) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
}
