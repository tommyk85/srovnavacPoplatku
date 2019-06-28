<?php

$znak = "i";
$empty_znak = ".";
$i=1;
$n=50;      // user input
$c = ($n % 2 == 0 ? $n++ : $n);
$c2 = $c - 1;
$empty_val = intval($c / 2);

while ($i <= $n){

echo str_repeat($empty_znak, $empty_val);
echo str_repeat($znak, $c - $c2);
echo "<br />";

$c2 = $c2 - 2;
$empty_val--;

$i = $i + 2;
}

echo str_repeat($empty_znak, intval($c / 2));
echo $znak;
?>