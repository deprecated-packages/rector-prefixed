<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\EasyTesting\ValueObject;

final class InputAndExpected
{
    /**
     * @var string
     */
    private $input;
    /**
     * @var mixed
     */
    private $expected;
    /**
     * @param mixed $expected
     */
    public function __construct(string $original, $expected)
    {
        $this->input = $original;
        $this->expected = $expected;
    }
    public function getInput() : string
    {
        return $this->input;
    }
    /**
     * @return mixed
     */
    public function getExpected()
    {
        return $this->expected;
    }
}
