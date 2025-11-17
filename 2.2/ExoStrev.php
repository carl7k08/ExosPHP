<?php
 
function my_strrev($str) {
    $length = strlen($str);
    $result = "";
    $i = $length - 1;
    while ($i >= 0) {
        $result = $result . $str[$i];
        $i = $i - 1;
    }
    return $result;
}
echo my_strrev("Bonjour le monde !");
