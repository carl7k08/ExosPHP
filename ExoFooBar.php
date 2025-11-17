<?php

$nombre = 1;

while ($nombre <= 100) {
    if ($nombre % 3 == 0 && $nombre % 5 == 0) {
        echo "FooBar\n";
    }
    elseif ($nombre % 3 == 0) {
        echo "Foo\n";
    }
    elseif ($nombre % 5 == 0) {
        echo "Bar\n";
    }
    else {
        echo $nombre . "\n";
    }
    $nombre++; 
}

?>