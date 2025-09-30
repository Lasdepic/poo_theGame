<?php

require_once "./Personnages/Personnage.php";

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
            echo "ID: $id - Nom: {$combattant->name}\n";
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

        echo "Combat entre : " . $combattants[0]->name . " VS " . $combattants[1]->name . "\n";

        $this->degatInfliger($combattants[0], $combattants[1]);

        return $combattants;
    }

    function degatInfliger($attaquant, $cible)
    {
        $degatsBase = $attaquant->attack();

        $variation = rand(20, 45) / 100;
        $degatsFinaux = (int)($degatsBase * $variation);

        $cible->pv -= $degatsFinaux;

        if ($cible->pv < 0) {
            $cible->pv = 0;
        }

        echo "{$attaquant->name} inflige $degatsFinaux dégâts à {$cible->name}!\n";
        echo "{$cible->name} a maintenant {$cible->pv} PV\n";

        return $degatsFinaux;
    }

    function deadClean()
    {
        foreach ($this->combattants as $id => $combattant) {
            if ($combattant->pv <= 0) {
                echo "Suppression de {$combattant->name} (mort)\n";
                unset($this->combattants[$id]);
            }
        }
    }

    function endGame()
    {
        while (true) {
            $vivants = [];
            foreach ($this->combattants as $c) {
                if ($c->pv > 0) {
                    $vivants[] = $c;
                }
            }

            if (count($vivants) <= 1) {
                break;
            }

            $this->tourPlayer();
            $this->deadClean();
        }

        $vivants = [];
        foreach ($this->combattants as $c) {
            if ($c->pv > 0) {
                $vivants[] = $c;
            }
        }

        if (count($vivants) == 1) {
            $gagnant = $vivants[0];
            echo "Le gagnant est {$gagnant->name} avec {$gagnant->pv} PV restants.\n";
        } else {
            echo "La partie est terminée en match nul.\n";
        }
    }

    function startGame() {}
}

$random = new GameEngine();

$orc = new Orc("Shreck", 20, 80, 60);
$humain = new Humain("Jordan", 10, 140, 80);
$elfe = new Elfe("Le bouffon vert", 10, 130, 90);

$random->addCombattant($orc);
$random->addCombattant($humain);
$random->addCombattant($elfe);

$random->getId();
$random->tourPlayer();
$random->deadClean();
$random->endGame();
