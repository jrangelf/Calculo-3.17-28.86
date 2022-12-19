<?php

class AjustaDatas
{

	public static function converteNumMes ($num) { // converte 3 para MAR 
	  
	  $meses = array(".","JAN","FEV","MAR","ABR","MAI","JUN","JUL","AGO","SET","OUT","NOV","DEZ");	  
	  return $meses[intval($num)];  
	}


	public static function converteMesNum ($mes) { // converte MAR para 03 
	
	  $fita = 'JANFEVMARABRMAIJUNJULAGOSETOUTNOVDEZ';
	  $pos = strpos($fita, $mes);
	  return ($pos/3)+1;
	}


	public static function ajustaData ($strData) { // converte 01/07/2001 para JUL2001 
	  
	  $vetor = explode("/", $strData);
	  $mes = self::converteNumMes ($vetor[1]);
	  $ano = $vetor[2];
	  return $mes . $ano;  
	}


	public static function converteData($strData) { //converte JUL2001 para 01/07/2001
	
	  $mes = substr($strData,0,3);
	  $mes = self::converteMesNum ($mes);

	  if (strlen($mes) < 2) 
	  {
	  	$mes = "0" . $mes;
	  }  
	  
	  $ano = substr($strData,-4);
	  return "01/" . $mes . "/" . $ano; 

	}

	public static function calcularProRata($data){
		$dia = substr($data, 0,2);
		$mesAno = substr($data, 2,8);
		$proRataIndice = 0;

		if ($dia <> "01"){			
			$proRataIndice = ((30 - intval($dia))+1)/30;	
			$novadataInicio = "01" . $mesAno;
		}
		else{
			$novadataInicio = $data;
		}
		return [$proRataIndice, $novadataInicio];

	}


  	
}


?>