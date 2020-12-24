<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\Json;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\Option;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider;
final class JsonInliner
{
    /**
     * @var string
     * @see https://regex101.com/r/jhWo9g/1
     */
    private const SPACE_REGEX = '#\\s+#';
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\_PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    public function inlineSections(string $jsonContent) : string
    {
        $inlineSections = $this->parameterProvider->provideArrayParameter(\_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS);
        foreach ($inlineSections as $inlineSection) {
            $pattern = '#("' . \preg_quote($inlineSection, '#') . '": )\\[(.*?)\\](,)#ms';
            $jsonContent = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($jsonContent, $pattern, function (array $match) : string {
                $inlined = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($match[2], self::SPACE_REGEX, ' ');
                $inlined = \trim($inlined);
                $inlined = '[' . $inlined . ']';
                return $match[1] . $inlined . $match[3];
            });
        }
        return $jsonContent;
    }
}
