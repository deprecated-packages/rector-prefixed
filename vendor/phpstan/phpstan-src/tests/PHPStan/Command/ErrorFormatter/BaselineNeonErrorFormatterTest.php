<?php

declare (strict_types=1);
namespace PHPStan\Command\ErrorFormatter;

use _PhpScopera143bcca66cb\Nette\Neon\Neon;
use PHPStan\Analyser\Error;
use PHPStan\Command\AnalysisResult;
use PHPStan\File\SimpleRelativePathHelper;
use PHPStan\Testing\ErrorFormatterTestCase;
class BaselineNeonErrorFormatterTest extends \PHPStan\Testing\ErrorFormatterTestCase
{
    public function dataFormatterOutputProvider() : iterable
    {
        (yield ['No errors', 0, 0, 0, []]);
        (yield ['One file error', 1, 1, 0, [['message' => '#^Foo$#', 'count' => 1, 'path' => 'folder with unicode 😃/file name with "spaces" and unicode 😃.php']]]);
        (yield ['Multiple file errors', 1, 4, 0, [['message' => "#^Bar\nBar2\$#", 'count' => 1, 'path' => 'folder with unicode 😃/file name with "spaces" and unicode 😃.php'], ['message' => '#^Foo$#', 'count' => 1, 'path' => 'folder with unicode 😃/file name with "spaces" and unicode 😃.php'], ['message' => '#^Foo$#', 'count' => 1, 'path' => 'foo.php'], ['message' => "#^Bar\nBar2\$#", 'count' => 1, 'path' => 'foo.php']]]);
        (yield ['Multiple file, multiple generic errors', 1, 4, 2, [['message' => "#^Bar\nBar2\$#", 'count' => 1, 'path' => 'folder with unicode 😃/file name with "spaces" and unicode 😃.php'], ['message' => '#^Foo$#', 'count' => 1, 'path' => 'folder with unicode 😃/file name with "spaces" and unicode 😃.php'], ['message' => '#^Foo$#', 'count' => 1, 'path' => 'foo.php'], ['message' => "#^Bar\nBar2\$#", 'count' => 1, 'path' => 'foo.php']]]);
    }
    /**
     * @dataProvider dataFormatterOutputProvider
     *
     * @param string $message
     * @param int    $exitCode
     * @param int    $numFileErrors
     * @param int    $numGenericErrors
     * @param mixed[] $expected
     */
    public function testFormatErrors(string $message, int $exitCode, int $numFileErrors, int $numGenericErrors, array $expected) : void
    {
        $formatter = new \PHPStan\Command\ErrorFormatter\BaselineNeonErrorFormatter(new \PHPStan\File\SimpleRelativePathHelper(self::DIRECTORY_PATH));
        $this->assertSame($exitCode, $formatter->formatErrors($this->getAnalysisResult($numFileErrors, $numGenericErrors), $this->getOutput()), \sprintf('%s: response code do not match', $message));
        $this->assertSame(\trim(\_PhpScopera143bcca66cb\Nette\Neon\Neon::encode(['parameters' => ['ignoreErrors' => $expected]], \_PhpScopera143bcca66cb\Nette\Neon\Neon::BLOCK)), \trim($this->getOutputContent()), \sprintf('%s: output do not match', $message));
    }
    public function testFormatErrorMessagesRegexEscape() : void
    {
        $formatter = new \PHPStan\Command\ErrorFormatter\BaselineNeonErrorFormatter(new \PHPStan\File\SimpleRelativePathHelper(self::DIRECTORY_PATH));
        $result = new \PHPStan\Command\AnalysisResult([new \PHPStan\Analyser\Error('Escape Regex with file # ~ \' ()', 'Testfile')], ['Escape Regex without file # ~ <> \' ()'], [], [], \false, null, \true);
        $formatter->formatErrors($result, $this->getOutput());
        self::assertSame(\trim(\_PhpScopera143bcca66cb\Nette\Neon\Neon::encode(['parameters' => ['ignoreErrors' => [['message' => "#^Escape Regex with file \\# ~ ' \\(\\)\$#", 'count' => 1, 'path' => 'Testfile']]]], \_PhpScopera143bcca66cb\Nette\Neon\Neon::BLOCK)), \trim($this->getOutputContent()));
    }
    public function testEscapeDiNeon() : void
    {
        $formatter = new \PHPStan\Command\ErrorFormatter\BaselineNeonErrorFormatter(new \PHPStan\File\SimpleRelativePathHelper(self::DIRECTORY_PATH));
        $result = new \PHPStan\Command\AnalysisResult([new \PHPStan\Analyser\Error('Test %value%', 'Testfile')], [], [], [], \false, null, \true);
        $formatter->formatErrors($result, $this->getOutput());
        self::assertSame(\trim(\_PhpScopera143bcca66cb\Nette\Neon\Neon::encode(['parameters' => ['ignoreErrors' => [['message' => '#^Test %%value%%$#', 'count' => 1, 'path' => 'Testfile']]]], \_PhpScopera143bcca66cb\Nette\Neon\Neon::BLOCK)), \trim($this->getOutputContent()));
    }
}
