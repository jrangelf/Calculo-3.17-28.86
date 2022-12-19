<?php

class MatrizDeCalculo
{

	public static function adicionaRubrica(&$array, $codRubrica, $valorRubrica){
 
 		$array[] = array($codRubrica => $valorRubrica);

	}


	public static function adicionaRegistroMes(&$array, $dataReg, $registros){
 
 		//$array[] = array($dataReg => $registros);
		$array[$dataReg] = $registros;
	}


	public static function preencheMatrizCalculo($filtrados, $periodos, $orgao){

		$var = array();
		$matrizCalculo = array();
		

		foreach ($periodos as $periodo) {
	
			//echo  $periodo . "<br>"; //*DEBUG
				
			foreach ($filtrados as $filtrado) {					 
									
				if ($orgao == ''){

					if ($filtrado['data'] == $periodo){
			
						/*echo $filtrado['data'] . " ";
						echo $filtrado['registro']['codigoRubrica']. " ";
						echo $filtrado['registro']['descricaoRubrica']. " ";
		    			echo $filtrado['registro']['valorRubrica']. "<br>";*/

		    			self::adicionaRubrica($var, $filtrado['registro']['codigoRubrica'], $filtrado['registro']['valorRubrica']); 
		    		}

				} elseif ( ($filtrado['codigoOrgao'] == $orgao) and ($filtrado['data'] == $periodo)){				
			
					/*echo $filtrado['data'] . " ";
					echo $filtrado['registro']['codigoRubrica']. " ";
					echo $filtrado['registro']['descricaoRubrica']. " ";
		    		echo $filtrado['registro']['valorRubrica']. "<br>";*/
	    			
	    			self::adicionaRubrica($var, $filtrado['registro']['codigoRubrica'], $filtrado['registro']['valorRubrica']);    			
				}						
					
			}
    
    		//echo "<hr>"; //*DEBUG
    		
    		self::adicionaRegistroMes($matrizCalculo, $periodo, $var);
    		$var =[];    			

		}

		/*
		echo "MatrizDeCalculo -> preencheMatrizCalculo -> matrizCalculo:" . "<br>";
		echo json_encode($matrizCalculo); //*DEBUG
		echo "<hr>";
		*/
		return $matrizCalculo;
	}

	
}


?>