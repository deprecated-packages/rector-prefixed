<?php

declare (strict_types=1);
namespace Rector\ConsoleDiffer;

use RectorPrefix20210103\Nette\Utils\Strings;
use RectorPrefix20210103\SebastianBergmann\Diff\Differ;
/**
 * @deprecated Move to symplify
 */
final class MarkdownDifferAndFormatter
{
    /**
     * @var string
     * @see https://regex101.com/r/LE9Xwo/1
     */
    private const METADATA_REGEX = '#^(.*\\n){1}#';
    /**
     * @var string
     * @see https://regex101.com/r/yf7u2L/1
     */
    private const SPACE_AND_NEWLINE_REGEX = '#( ){1,}\\n#';
    /**
     * @var Differ
     */
    private $markdownDiffer;
    public function __construct(\RectorPrefix20210103\SebastianBergmann\Diff\Differ $markdownDiffer)
    {
        $this->markdownDiffer = $markdownDiffer;
    }
    public function bareDiffAndFormatWithoutColors(string $old, string $new) : string
    {
        if ($old === $new) {
            return '';
        }
        $diff = $this->markdownDiffer->diff($old, $new);
        // remove first line, just meta info added by UnifiedDiffOutputBuilder
        $diff = \RectorPrefix20210103\Nette\Utils\Strings::replace($diff, self::METADATA_REGEX, '');
        return $this->removeTrailingWhitespaces($diff);
    }
    /**
     * Removes UnifiedDiffOutputBuilder generated pre-spaces " \n" => "\n"
     */
    private function removeTrailingWhitespaces(string $diff) : string
    {
        $diff = \RectorPrefix20210103\Nette\Utils\Strings::replace($diff, self::SPACE_AND_NEWLINE_REGEX, \PHP_EOL);
        return \rtrim($diff);
    }
}
