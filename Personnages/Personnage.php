<?php

abstract class Personnage
{
    public string $name;
    public int $force;
    public int $pv;
    public int $endurance;

    function __construct($name, $force, $pv, $endurance)
    {

        $this->name = $name;
        $this->force = $force;
        $this->pv = $pv;
        $this->endurance = $endurance;
    }

    public function attack(Personnage $cible)
    {
        $degatsBase = $this->force;

        $variation = rand(150, 300) / 100;
        $degatsFinaux = (int)($degatsBase * $variation);

        $cible->pv -= $degatsFinaux;

        if ($cible->pv < 0) {
            $cible->pv = 0;
        }

        $perteEndurance = rand(10, 15);
        $this->endurance -= $perteEndurance;

        if ($this->endurance < 0) {
            $this->endurance = 0;
        }

        $blue = "\033[34m"; 
        $red = "\033[31m"; 
        $green = "\033[32m";
        $reset = "\033[0m"; // La couleur normal du terminal

        echo "                                    \n";
        echo "{$blue}{$this->name}{$reset} inflige {$red}$degatsFinaux dégâts{$reset} à {$blue}{$cible->name}{$reset}!\n";
        echo "{$blue}{$this->name}{$reset} perd {$red}$perteEndurance points d'endurance !{$reset}\n";
        echo "Il reste {$green}{$this->endurance} endurance{$reset} à {$blue}{$this->name}{$reset}\n";
        echo "{$blue}{$cible->name}{$reset} a maintenant {$red}{$cible->pv} PV{$reset}\n";

        return $degatsFinaux;
    }
}

class Orc extends Personnage
{
    function __construct($name, $force, $pv, $endurance)
    {
        parent::__construct($name, $force, $pv, $endurance);
    }
}

class Humain extends Personnage
{
    function __construct($name, $force, $pv, $endurance)
    {
        parent::__construct($name, $force, $pv, $endurance);
    }
}

class Elfe extends Personnage
{
    function __construct($name, $force, $pv, $endurance)
    {
        parent::__construct($name, $force, $pv, $endurance);
    }
}
