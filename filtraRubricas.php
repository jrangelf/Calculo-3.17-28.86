<?php

class Calculo317
{
	
}


/*

$var = array();

$var[] = array("00001"=>156.25);
              
$var[] = array("00013"=>658.89);
              
$var[] = array("00200"=>1658.74);

$dataReg = "01/01/1995";

$calculo = array (
	$dataReg => $var
);



echo json_encode($var);
echo "<br>";

echo json_encode($calculo);
echo "<br>";


print_r($var);
echo "<br>";
print_r($calculo);

*/


function adicionaRubrica(&$array, $codRubrica, $valorRubrica)
{
 
 $array[] = array($codRubrica => $valorRubrica);

};


function adicionaRegistroMes(&$array, $dataReg,$registros)
{
 
 $array[] = array($dataReg => $registros);

}

/*
$var = array();
$dataReg = "01/01/1995";

adicionaRubrica($var, "00001", "1256,25"); 
adicionaRubrica($var, "00013", "589,47"); 
adicionaRubrica($var, "00200", "286,32"); 

$calculo = array(
	$dataReg => $var
);

*/

$var = array();
$calculo = array();

$dataReg = "01/01/1995";

adicionaRubrica($var, "00001", "1256,25"); 
adicionaRubrica($var, "00013", "589,47"); 
adicionaRubrica($var, "00200", "286,32"); 


adicionaRegistroMes($calculo,$dataReg,$var);

adicionaRegistroMes($calculo,"01/02/1995",$var);

adicionaRegistroMes($calculo,"01/03/1995",$var);

adicionaRegistroMes($calculo,"01/04/1995",$var);



echo json_encode($var);
echo "<br>";
echo "<br>";
print_r($var);

echo "<br>";
echo "<br>";

echo json_encode($calculo);
echo "<br>";
echo "<br>";
print_r($calculo);








?>