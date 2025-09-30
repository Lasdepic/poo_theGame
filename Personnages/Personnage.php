<?php

abstract class Personnage{
    public string $name;
    public int $force;
    public int $pv;
    public int $endurance;

function __construct($name, $force, $pv, $endurance){

    $this->name = $name;
    $this->force = $force;
    $this->pv = $pv;
    $this->endurance = $endurance;
}

public function attack(Personnage $cible){
    $degatsBase = $this->force;

    $variation = rand(150, 300) / 100;
    $degatsFinaux = (int)($degatsBase * $variation);

    $cible->pv -= $degatsFinaux;

    if ($cible->pv < 0) {
        $cible->pv = 0;
    }

    echo "{$this->name} inflige $degatsFinaux dégâts à {$cible->name}!\n";
    echo "{$cible->name} a maintenant {$cible->pv} PV\n";

    return $degatsFinaux;
}
}

class Orc extends Personnage{
    function __construct($name, $force, $pv, $endurance){
        parent::__construct($name, $force, $pv, $endurance);
    }
}

class Humain extends Personnage{
      function __construct($name, $force, $pv, $endurance){
        parent::__construct($name, $force, $pv, $endurance);
    }
}

class Elfe extends Personnage{
      function __construct($name, $force, $pv, $endurance){
        parent::__construct($name, $force, $pv, $endurance);
    }
}