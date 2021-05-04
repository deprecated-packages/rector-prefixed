<?php

declare (strict_types=1);
namespace RectorPrefix20210504;

require_once __DIR__ . '/../vendor/autoload.php';
class PharTest extends \PHPStan\Testing\LevelsTestCase
{
    public function dataTopics() : array
    {
        return [['strictRulesExtension']];
    }
    public function getDataPath() : string
    {
        return __DIR__ . '/data';
    }
    public function getPhpStanExecutablePath() : string
    {
        return __DIR__ . '/../phpstan.phar';
    }
    public function getPhpStanConfigPath() : ?string
    {
        return __DIR__ . '/phpstan.neon';
    }
}
\class_alias('RectorPrefix20210504\\PharTest', 'PharTest', \false);
