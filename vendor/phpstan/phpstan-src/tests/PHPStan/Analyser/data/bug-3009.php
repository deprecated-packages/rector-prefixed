<?php

namespace _PhpScoper88fe6e0ad041\Bug3009;

use function PHPStan\Analyser\assertType;
class HelloWorld
{
    public function createRedirectRequest(string $redirectUri) : ?string
    {
        $redirectUrlParts = \parse_url($redirectUri);
        if (\false === \is_array($redirectUrlParts) || \true === \array_key_exists('host', $redirectUrlParts)) {
            \PHPStan\Analyser\assertType('array(?\'scheme\' => string, ?\'host\' => string, ?\'port\' => int, ?\'user\' => string, ?\'pass\' => string, ?\'path\' => string, ?\'query\' => string, ?\'fragment\' => string)|false', $redirectUrlParts);
            return null;
        }
        \PHPStan\Analyser\assertType('array(?\'scheme\' => string, ?\'host\' => string, ?\'port\' => int, ?\'user\' => string, ?\'pass\' => string, ?\'path\' => string, ?\'query\' => string, ?\'fragment\' => string)', $redirectUrlParts);
        if (\true === \array_key_exists('query', $redirectUrlParts)) {
            \PHPStan\Analyser\assertType('array(?\'scheme\' => string, ?\'host\' => string, ?\'port\' => int, ?\'user\' => string, ?\'pass\' => string, ?\'path\' => string, \'query\' => string, ?\'fragment\' => string)', $redirectUrlParts);
            $redirectServer['QUERY_STRING'] = $redirectUrlParts['query'];
        }
        \PHPStan\Analyser\assertType('array(?\'scheme\' => string, ?\'host\' => string, ?\'port\' => int, ?\'user\' => string, ?\'pass\' => string, ?\'path\' => string, ?\'query\' => string, ?\'fragment\' => string)', $redirectUrlParts);
        return 'foo';
    }
}
