<?php

declare (strict_types=1);
namespace RectorPrefix20210408\Symplify\ComposerJsonManipulator\Json;

use RectorPrefix20210408\Nette\Utils\Strings;
use RectorPrefix20210408\Symplify\ComposerJsonManipulator\ValueObject\Option;
use RectorPrefix20210408\Symplify\PackageBuilder\Parameter\ParameterProvider;
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
    public function __construct(\RectorPrefix20210408\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    public function inlineSections(string $jsonContent) : string
    {
        $inlineSections = $this->parameterProvider->provideArrayParameter(\RectorPrefix20210408\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS);
        foreach ($inlineSections as $inlineSection) {
            $pattern = '#("' . \preg_quote($inlineSection, '#') . '": )\\[(.*?)\\](,)#ms';
            $jsonContent = \RectorPrefix20210408\Nette\Utils\Strings::replace($jsonContent, $pattern, function (array $match) : string {
                $inlined = \RectorPrefix20210408\Nette\Utils\Strings::replace($match[2], self::SPACE_REGEX, ' ');
                $inlined = \trim($inlined);
                $inlined = '[' . $inlined . ']';
                return $match[1] . $inlined . $match[3];
            });
        }
        return $jsonContent;
    }
}
