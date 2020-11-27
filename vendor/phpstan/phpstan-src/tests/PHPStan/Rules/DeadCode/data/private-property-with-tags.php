<?php

namespace _PhpScoper88fe6e0ad041\PrivatePropertyWithTags;

use _PhpScoper88fe6e0ad041\Doctrine\ORM\Mapping as ORM;
class Foo
{
    /**
     * @ORM\Column(type="big_integer", options={"unsigned": true})
     */
    private $title;
    /**
     * @get
     */
    private $text;
    /**
     * @ORM\Column(type="big_integer", options={"unsigned": true})
     * @get
     */
    private $author;
}
