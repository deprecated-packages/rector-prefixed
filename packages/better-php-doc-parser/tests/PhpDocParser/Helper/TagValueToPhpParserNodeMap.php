<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\Helper;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\CustomIdGeneratorTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertTypeTagValueNode;
final class TagValueToPhpParserNodeMap
{
    /**
     * @var string[]
     */
    public const MAP = [
        \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class,
        \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\SlugTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class,
        \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo\BlameableTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class,
        // symfony/validation
        \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertChoiceTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class,
        \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints\AssertTypeTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class,
        // doctrine
        \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class,
        \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinTableTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class,
        \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class,
        \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\TableTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class,
        \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\CustomIdGeneratorTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class,
        \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\GeneratedValueTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class,
        \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EmbeddedTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class,
        // special case for constants
        \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class,
        \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioTemplateTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class,
        \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio\SensioMethodTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class,
        \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\TemplateTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class,
        \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class => \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class,
    ];
}
