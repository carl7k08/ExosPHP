<?php

function determinerNiveauScolaire($age) {
    if ($age < 3) {
        return "creche";
    }
    elseif ($age < 6) {
        return "maternelle";
    }
    elseif ($age < 11) {
        return "primaire";
    }
    elseif ($age < 16) {
        return "college";
    }
    elseif ($age < 18) {
        return "lycée";
    }
    else {
        return "rien";
    }
}

echo "2 ans : " . determinerNiveauScolaire(2) . "\n";
echo "8 ans : " . determinerNiveauScolaire(8) . "\n";
echo "17 ans : " . determinerNiveauScolaire(17) . "\n";
echo "25 ans : " . determinerNiveauScolaire(25) . "\n";

?>