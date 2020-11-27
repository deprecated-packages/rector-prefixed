<?php

namespace _PhpScopera143bcca66cb\Bug3404;

new \finfo();
new \finfo(\FILEINFO_MIME_TYPE);
new \finfo(0, 'foo', 'bar');
