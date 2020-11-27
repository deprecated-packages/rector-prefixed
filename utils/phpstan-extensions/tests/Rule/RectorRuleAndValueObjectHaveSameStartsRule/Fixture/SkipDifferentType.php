<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\Tests\Rule\RectorRuleAndValueObjectHaveSameStartsRule\Fixture;

use Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use Rector\PHPStanExtensions\Tests\Rule\RectorRuleAndValueObjectHaveSameStartsRule\Source\ConfigureValueObject;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (object $random) : void {
    $random->set(\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\PHPStanExtensions\Tests\Rule\RectorRuleAndValueObjectHaveSameStartsRule\Source\ConfigureValueObject(), new \Rector\PHPStanExtensions\Tests\Rule\RectorRuleAndValueObjectHaveSameStartsRule\Source\ConfigureValueObject()])]]);
};
