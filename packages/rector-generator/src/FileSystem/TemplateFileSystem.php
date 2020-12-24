<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RectorGenerator\FileSystem;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Rector\RectorGenerator\Finder\TemplateFinder;
use _PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class TemplateFileSystem
{
    /**
     * @var string
     * @see https://regex101.com/r/fw3jBe/1
     */
    private const FIXTURE_SHORT_REGEX = '#/Fixture/#';
    /**
     * @var string
     * @see https://regex101.com/r/HBcfXd/1
     */
    private const PACKAGE_RULES_PATH_REGEX = '#(packages|rules)\\/__package__#i';
    /**
     * @var string
     * @see https://regex101.com/r/tOidWU/1
     */
    private const CONFIGURED_OR_EXTRA_REGEX = '#(__Configured|__Extra)#';
    /**
     * @param string[] $templateVariables
     */
    public function resolveDestination(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, array $templateVariables, \_PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe, string $targetDirectory) : string
    {
        $destination = $smartFileInfo->getRelativeFilePathFromDirectory(\_PhpScopere8e811afab72\Rector\RectorGenerator\Finder\TemplateFinder::TEMPLATES_DIRECTORY);
        // normalize core package
        if (!$rectorRecipe->isRectorRepository()) {
            // special keyword for 3rd party Rectors, not for core Github contribution
            $destination = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($destination, self::PACKAGE_RULES_PATH_REGEX, 'utils/rector');
        }
        // remove _Configured|_Extra prefix
        $destination = $this->applyVariables($destination, $templateVariables);
        $destination = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($destination, self::CONFIGURED_OR_EXTRA_REGEX, '');
        // remove ".inc" protection from PHPUnit if not a test case
        if ($this->isNonFixtureFileWithIncSuffix($destination)) {
            $destination = \_PhpScopere8e811afab72\Nette\Utils\Strings::before($destination, '.inc');
        }
        // special hack for tests, to PHPUnit doesn't load the generated file as test case
        /** @var string $destination */
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($destination, 'Test.php') && \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $destination .= '.inc';
        }
        return $targetDirectory . \DIRECTORY_SEPARATOR . $destination;
    }
    /**
     * @param mixed[] $variables
     */
    private function applyVariables(string $content, array $variables) : string
    {
        return \str_replace(\array_keys($variables), \array_values($variables), $content);
    }
    private function isNonFixtureFileWithIncSuffix(string $filePath) : bool
    {
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::match($filePath, self::FIXTURE_SHORT_REGEX)) {
            return \false;
        }
        return \_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($filePath, '.inc');
    }
}
