<?php

function calcMoy($tableau) {
    $nombreElements = count($tableau);
    
    if ($nombreElements === 0) {
        return 0;
    }

    $somme = array_sum($tableau);
    return $somme / $nombreElements;
}

$notes = [12, 15, 9, 14.5];
$resultat = calcMoy($notes);

echo "La moyenne est : " . $resultat;

?>