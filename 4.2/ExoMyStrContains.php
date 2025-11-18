<?php

function my_str_contains($phrase, $mot_a_chercher) {
    $taillePhrase = strlen($phrase);
    $tailleMot = strlen($mot_a_chercher);

    if ($tailleMot > $taillePhrase) {
        return false;
    }

    $limite = $taillePhrase - $tailleMot;

    for ($i = 0; $i <= $limite; $i++) {
        
        $correspondance_trouvee = true;
        for ($j = 0; $j < $tailleMot; $j++) {
            if ($phrase[$i + $j] !== $mot_a_chercher[$j]) {
                $correspondance_trouvee = false;
                break;
            }
        }

        if ($correspondance_trouvee === true) {
            return true;
        }
    }

    return false;
}
function affichage($resultat) {
    return $resultat ? "VRAI" : "FAUX";
}

echo "1: " . affichage(my_str_contains("bonjour", "bonjour tout le monde")) . "\n";
echo "2: " . affichage(my_str_contains("bonjour tout le monde", "bonjour")) . "\n";
echo "3: " . affichage(my_str_contains("le bonjour le monde", "le m")) . "\n";
echo "4: " . affichage(my_str_contains("bonjour le monde", "monde")) . "\n";
echo "5: " . affichage(my_str_contains("bonjour le monde", "monde est grand")) . "\n";

?>