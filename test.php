<?php

function calculate() {
    $sum = 0;
    for ($i = 1; $i <= 100000000; $i++) {
        $sum += sqrt($i);
    }
    return $sum;
}

$start = microtime(true);
echo "Natija: " . calculate() . "\n";
$end = microtime(true);

echo "Ishlash vaqti: " . ($end - $start) . " soniya\n";

?>
