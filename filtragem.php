<?php

class FiltragemPorRubricas
{

	//seleciona somente as rubricas cujos sequenciais sejam 0 ou 1 e rendimento "R", exceto as de abate-teto que são "D"
		
	public static function verificaRubrica($codigo, $indicador, $listarubricas, $listaAT, $sequencial) {
		
		if (($indicador <> "R") && (!in_array (trim($codigo), $listaAT))) {		
			
			return 0;
	    }    
		else
		{
			if (in_array (trim($codigo), $listarubricas) && ($sequencial=="1" || $sequencial=="0" || $sequencial=="6") ) {
		  		
		  		return 1;
		  	}
		
		}	

	}	
	
	public static function filtrar($arquivo, $rubricas, $rubricasAT, $dataInicio, $dataFinal){
		
				
		$json_a = json_decode($arquivo, true);

		//$tamExtracao = sizeof($json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros']);
		$tamExtracao = sizeof($json_a['dadosFinanceirosHistorico']);


		$registro = array(
			'codigoRubrica' => '',
			'descricaoRubrica' => '',
			'valorRubrica' => '' 
		);

		$dataRegistro =  array(
			'data' => '',
			'codigoOrgao' => '',
			'registro' => $registro
		);

		$filtrado = [];
		$listaMesAnoPagto = [];
		$listaCodDescRubricas = [];
				
		for ($x = 0; $x <= $tamExtracao-1; $x++) {
    
			//$codOrgao = $json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros'][$x]['codigoOrgao'];
			//$mesAnoPagto = $json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros'][$x]['mesAnoPagamento'];
            
			$codOrgao = $json_a['dadosFinanceirosHistorico'][$x]['codigoOrgao'];
			$mesAnoPagto = $json_a['dadosFinanceirosHistorico'][$x]['mesAnoPagamento'];


			$inicio = strtotime(str_replace("/","-",$dataInicio)); 
			$final = strtotime(str_replace("/","-",$dataFinal)); 
			$dataReg = AjustaDatas::converteData ($mesAnoPagto);
		    $dataReg = strtotime(str_replace("/","-",$dataReg));

			if ($dataReg >= $inicio  && $dataReg <= $final) {
		
				//$tamFicha = sizeof($json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros'][$x]['dadosFinanceiros']['DadosFinanceiros']);

				$tamFicha = sizeof($json_a['dadosFinanceirosHistorico'][$x]['dadosFinanceiros']['DadosFinanceiros']);
		  
		 		for ($y = 0; $y <= $tamFicha-1; $y++) {

		 			/*
		 			$codigoRubrica = $json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros'][$x]['dadosFinanceiros']['DadosFinanceiros'][$y]['codRubrica'];

		 			$indicadorRD = $json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros'][$x]['dadosFinanceiros']['DadosFinanceiros'][$y]['indicadorRD'];

		 			$descricaoRubrica = $json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros'][$x]['dadosFinanceiros']['DadosFinanceiros'][$y]['nomeRubrica'];  

		    		$valorRubrica = $json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros'][$x]['dadosFinanceiros']['DadosFinanceiros'][$y]['valorRubrica'];

		    		$sequencial = $json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros'][$x]['dadosFinanceiros']['DadosFinanceiros'][$y]['numeroSeq'];
		    		*/

					$codigoRubrica = $json_a['dadosFinanceirosHistorico'][$x]['dadosFinanceiros']['DadosFinanceiros'][$y]['codRubrica'];

		 			$indicadorRD = $json_a['dadosFinanceirosHistorico'][$x]['dadosFinanceiros']['DadosFinanceiros'][$y]['indicadorRD'];

		 			$descricaoRubrica = $json_a['dadosFinanceirosHistorico'][$x]['dadosFinanceiros']['DadosFinanceiros'][$y]['nomeRubrica'];  

		    		$valorRubrica = $json_a['dadosFinanceirosHistorico'][$x]['dadosFinanceiros']['DadosFinanceiros'][$y]['valorRubrica'];

		    		$sequencial = $json_a['dadosFinanceirosHistorico'][$x]['dadosFinanceiros']['DadosFinanceiros'][$y]['numeroSeq'];



		    		if (self::verificaRubrica($codigoRubrica, $indicadorRD, $rubricas, $rubricasAT, $sequencial) <> 0) {


		    			$registro['codigoRubrica'] = $codigoRubrica;
		    			$registro['descricaoRubrica'] = $descricaoRubrica;
		    			$registro['valorRubrica'] = $valorRubrica;		    			

		    			$dataRegistro['data'] = AjustaDatas::converteData ($mesAnoPagto);
		    			$dataRegistro['codigoOrgao'] = $codOrgao;
		    			$dataRegistro['registro'] = $registro;

		    			
		
                        $filtrado[] = $dataRegistro;
                                                
						if (!in_array($dataRegistro['data'], $listaMesAnoPagto)) { 
						    $listaMesAnoPagto[] = $dataRegistro['data']; 
						}                                                                       

                        if (!array_key_exists($codigoRubrica, $listaCodDescRubricas)) {
    						$listaCodDescRubricas [$codigoRubrica] = $descricaoRubrica;
						}
                        	
		            }	
		 		
		 		}
		    
		    }
	    
	    }
	    
	    ksort($listaCodDescRubricas);
	    
	    //echo json_encode($filtrado);	    
	    
	    return [$filtrado, $listaMesAnoPagto, $listaCodDescRubricas];

	}
  	
}


?>