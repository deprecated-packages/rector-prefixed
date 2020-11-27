<?php

namespace _PhpScoper26e51eeacccf\PrivatePropertyWithTags;

use _PhpScoper26e51eeacccf\Doctrine\ORM\Mapping as ORM;
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
