<?php

declare (strict_types=1);
namespace Rector\Core\Configuration\MinimalVersionChecker;

use _PhpScoper88fe6e0ad041\Nette\Utils\Json;
use _PhpScoper88fe6e0ad041\Nette\Utils\Strings;
/**
 * @see \Rector\Core\Tests\Configuration\ComposerJsonParserTest
 */
final class ComposerJsonParser
{
    /**
     * @var string
     */
    private $composerJson;
    public function __construct(string $composerJson)
    {
        $this->composerJson = $composerJson;
    }
    public function getPhpVersion() : string
    {
        $composerArray = \_PhpScoper88fe6e0ad041\Nette\Utils\Json::decode($this->composerJson, \_PhpScoper88fe6e0ad041\Nette\Utils\Json::FORCE_ARRAY);
        return \_PhpScoper88fe6e0ad041\Nette\Utils\Strings::trim($composerArray['require']['php'], '~^>=*.');
    }
}
