<?php

declare (strict_types=1);
namespace PHPStan\Type\Generic;

use PHPStan\Type\IntersectionType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\VerbosityLevel;
class TemplateTypeHelperTest extends \PHPStan\Testing\TestCase
{
    public function testIssue2512() : void
    {
        $templateType = \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a'), 'T', null, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        $type = \PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($templateType, new \PHPStan\Type\Generic\TemplateTypeMap(['T' => $templateType]));
        $this->assertEquals('T (function a(), parameter)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()));
        $type = \PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($templateType, new \PHPStan\Type\Generic\TemplateTypeMap(['T' => new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\DateTime::class), $templateType])]));
        $this->assertEquals('DateTime&T (function a(), parameter)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()));
    }
}
