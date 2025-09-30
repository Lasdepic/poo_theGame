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

public function attack(){
    echo "$this->name attack et enlève $this->force pv \n";
    return $this->force;
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