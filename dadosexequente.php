<?php

class DadosExequente
{

	public static function formatCnpjCpf($value){
  		$cnpj_cpf = preg_replace("/\D/", '', $value);
  
  		if (strlen($cnpj_cpf) === 11) {
    		return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
  		} 
  
  		return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
	}
	

	public static function buscarDadosExequente($arquivo){
		
				
		$json_a = json_decode($arquivo, true);		
		
		$nomeExequente = $json_a['dadosPessoais']['nome']; 
		//$IU = $json_a['dadosFuncionais][DadosFuncionais][0]['Pessoais']['nome'];
		$IU = $json_a['dadosFuncionais']['DadosFuncionais'][0]['identUnica'];
		//$CPF = $json_a['dadosDocumentacao']['numCPF'];
		
		echo "Nome: " . $nomeExequente . "<br>";
		echo "IU: " . $IU . "<br>";
		//echo "CPF: " . self::formatCnpjCpf($CPF) . "<br>";
		    
	    
	    return 0;

	}
  	
}


?>