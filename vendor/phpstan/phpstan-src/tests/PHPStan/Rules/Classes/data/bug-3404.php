<?php

namespace _PhpScoper26e51eeacccf\Bug3404;

new \finfo();
new \finfo(\FILEINFO_MIME_TYPE);
new \finfo(0, 'foo', 'bar');
