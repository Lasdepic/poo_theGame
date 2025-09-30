<?php

require_once __DIR__ . "/Personnages/Personnage.php";
require_once __DIR__ . "/Personnages/Orc.php";
require_once __DIR__ . "/Personnages/Humain.php";
require_once __DIR__ . "/Personnages/Elfe.php";

class GameEngine
{
    private array $combattants = [];
    private int $nextId = 1;

    function addCombattant(Personnage $p)
    {
        $id = $this->nextId++;
        $this->combattants[$id] = $p;
        return $id;
    }

    function getId()
    {
        foreach ($this->combattants as $id => $combattant) {

            $blue = "\033[34m";
            $yellow = "\033[33m";
            $reset = "\033[0m";

            echo "                                          \n";
            echo "Combattant {$yellow}n°$id :{$reset}\n";
            echo "{$blue}{$combattant->name}{$reset}\n";
        }
    }

    function tourPlayer()
    {
        $ids = array_keys($this->combattants);

        if (count($ids) < 2) {
            return null;
        }

        $joueur1 = rand(0, count($ids) - 1);
        $joueur2 = rand(0, count($ids) - 1);

        if ($joueur1 == $joueur2) {
            if ($joueur2 == count($ids) - 1) {
                $joueur2 = 0;
            } else {
                $joueur2 = $joueur2 + 1;
            }
        }

        $combattants = [$this->combattants[$ids[$joueur1]], $this->combattants[$ids[$joueur2]]];

        $blue = "\033[34m";
        $yellow = "\033[33m";
        $reset = "\033[0m";

        echo "                                          \n";
        echo "{$yellow}################## FIGHT ################{$reset}\n";
        echo "                                          \n";
        echo "Combat entre : {$blue}{$combattants[0]->name}{$reset} {$yellow}VS{$reset} {$blue}{$combattants[1]->name}{$reset} 🤼\n";

        $combattants[0]->attack($combattants[1]);

        return $combattants;
    }

    function deadClean()
    {
        foreach ($this->combattants as $id => $combattant) {
            if ($combattant->pv <= 0 || $combattant->endurance <= 0) {

                $blue = "\033[34m";
                $red = "\033[31m";
                $reset = "\033[0m";

                echo "                                          \n";
                echo "===================\n";
                if ($combattant->pv <= 0) {
                    echo "{$blue}$combattant->name{$reset} {$red}est mort{$reset} ☠️\n";
                } else {
                    echo "{$blue}$combattant->name {$reset} {$red}est à court d'endurance{$reset} 😵\n";
                }
                echo "===================\n";
                echo "                                          \n";
                unset($this->combattants[$id]);
            }
        }
    }

    function endGame()
    {
        while (true) {
            $domeDuTonnere = [];
            foreach ($this->combattants as $c) {
                if ($c->pv > 0 && $c->endurance > 0) {
                    $domeDuTonnere[] = $c;
                }
            }

            if (count($domeDuTonnere) <= 1) {
                break;
            }

            $this->tourPlayer();
            $this->deadClean();
        }

        $domeDuTonnere = [];
        foreach ($this->combattants as $c) {
            if ($c->pv > 0 && $c->endurance > 0) {
                $domeDuTonnere[] = $c;
            }
        }

        if (count($domeDuTonnere) == 1) {

            $green = "\033[32m";
            $reset = "\033[0m";
            $gagnant = $domeDuTonnere[0];
            echo "Le gagnant du tournoi est {$green}{$gagnant->name}{$reset} 🏆\n";
        } else {
            echo "La partie est terminée en match nul.\n";
        }
    }

    function startGame()
    {
        $this->getId();
        $this->endGame();
    }
}

$random = new GameEngine();

$orc = new Orc("Shreck", 20, 80, 60);
$humain = new Humain("Jordan", 10, 140, 80);
$elfe = new Elfe("Le bouffon vert", 10, 130, 90);

$random->addCombattant($orc);
$random->addCombattant($humain);
$random->addCombattant($elfe);

$random->startGame();
