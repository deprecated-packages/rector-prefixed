<?php

namespace _PhpScoperbd5d0c5f7638\RequireTernaryParenthesesBug;

function getPremiseName(\_PhpScoperbd5d0c5f7638\RequireTernaryParenthesesBug\PartnerProfilePremise $premise) : string
{
    $address = $premise->hasAddress() ? $premise->getAddress() : null;
    return $address !== null && $address->getCity() !== null && $address->getStreet() !== null ? \sprintf('%s, %s, %s', $premise->getName(), $address->getStreet(), $address->getCity()) : ($address !== null && $address->getCity() !== null ? \sprintf('%s, %s', $premise->getName(), $address->getCity()) : $premise->getName());
}
