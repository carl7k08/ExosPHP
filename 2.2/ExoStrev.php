<?php

function my_strrev($chaine) {
    $resultat = "";
    $longueur = strlen($chaine);

    for ($i = $longueur - 1; $i >= 0; $i--) {
        $resultat .= $chaine[$i];
    }

    return $resultat;
}

$texte = "Bonjour";
echo my_strrev($texte);

?>