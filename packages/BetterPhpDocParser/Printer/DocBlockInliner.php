<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Printer;

use RectorPrefix20210420\Nette\Utils\Strings;
final class DocBlockInliner
{
    /**
     * @var string
     * @see https://regex101.com/r/Mjb0qi/1
     */
    const NEWLINE_CLOSING_DOC_REGEX = "#\n \\*\\/\$#";
    /**
     * @var string
     * @see https://regex101.com/r/U5OUV4/2
     */
    const NEWLINE_MIDDLE_DOC_REGEX = "#\n \\* #";
    public function inline(string $docContent) : string
    {
        $docContent = \RectorPrefix20210420\Nette\Utils\Strings::replace($docContent, self::NEWLINE_MIDDLE_DOC_REGEX, ' ');
        return \RectorPrefix20210420\Nette\Utils\Strings::replace($docContent, self::NEWLINE_CLOSING_DOC_REGEX, ' */');
    }
}
