<?php 
phpinfo(); 

function faktorial($cislo){

if($cislo < 0 || !is_numeric($cislo))
die ("zadejte kladné číslo.");

elseif($cislo <= 1)
return 1;

else {

$f = $cislo;

  while($cislo > 1){
  $f *= --$cislo;
  }

return $f;
}};



$test = array (1, 2, 4, 6, 5, 3, 6); 

// test z php 1
//echo faktorial($test1);   




// test 9

function array_combine_($keys, $values)
{
    $result = array();
    foreach ($keys as $i => $k) {
        $result[$k][] = $values[$i];
    }
    array_walk($result, create_function('&$v', '$v = (count($v) == 1)? array_pop($v): $v;'));
    return    $result;
};


if(dupl($test) == 0)
$test = array_flip($test);

else {
$test = array_combine_(array_values($test), array_keys($test));  
}


echo "<br />";
print_r($test);




function swap($array){

}


// test 4


function dupl($array){
sort($array);
$d = 0;
  for($i = 0; $i < count($array)-1; ++$i){
    
    if($array[$i] == $array[$i+1]){
    $d = 1;
    break;
    }
  }
  return $d; // == 1 ? "duplikat nalezen" : "bez duplikatu";
};

//echo dupl($test); 

//test 2

function rev($str){
$a = explode(" ", $str);
$a = array_reverse($a);
return implode(" ", $a);
};



// test 3
 $age = 5;
 $score = 12; 
//echo 'Your score is: '.($score > 10 ? ($age > 10 ? 'Average' : 'Exceptional') : ($age > 10 ? 'Horrible' : 'Average') );







?>
