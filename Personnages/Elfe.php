<?php

require_once __DIR__ . "/Personnage.php";

class Elfe extends Personnage
{
    function __construct($name, $force, $pv, $endurance)
    {
        parent::__construct($name, $force, $pv, $endurance);
    }
}   