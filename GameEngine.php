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
            echo "Combattant n°$id :\n";
            echo "{$combattant->name}\n";
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

        echo "                                          \n";
        echo "################## FIGHT ################\n";
        echo "                                          \n";
        echo "Combat entre : " . $combattants[0]->name . " VS " . $combattants[1]->name . " 🤼\n";

        $combattants[0]->attack($combattants[1]);

        return $combattants;
    }

    function deadClean()
    {
        foreach ($this->combattants as $id => $combattant) {
            if ($combattant->pv <= 0) {
                echo "                                          \n";
                echo "===================\n";
                echo "$combattant->name est mort ☠️\n";
                echo "===================\n";
                echo "                                          \n";
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
            echo "Le gagnant du tournoi est {$gagnant->name} 🏆\n";
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
