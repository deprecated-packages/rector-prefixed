<?php

namespace _PhpScopera143bcca66cb\TestInstantiation;

function () {
    throw new \SoapFault('Server', 123);
    throw new \SoapFault('Server', 'Some error message');
};
