<?php

include ("ajustadatas.php");
include ("filtragem.php");
include ("geramatrizcalculo.php");
include ("calculo.php");
include ("dadosexequente.php");

$DEBUG0 = false;

//------------------------------------------------
// * início - dados serão enviados pelo front-end 
//------------------------------------------------

$nomedoarquivo = "26544962104-consulta1.json"; 

$arquivo = file_get_contents('/Users/rangel/dadosSiape/' . $nomedoarquivo);

//$arquivo = file_get_contents('/Users/rangel/317tst/teste24733830904.json'); 
//$arquivo = file_get_contents('/Users/rangel/dadosSiape/09901957168-consulta1.json');
//$arquivo = file_get_contents('/Users/rangel/dadosSiape/26544962104-consulta1.json');


// rubricas utilizada no cálculo- retirar a 00176 - Gratificação Natalina.
$rubricasCalculo = 
	[	"00001", "00005", "00013", "00015", "00018", "00024", "00025", "00034", "00053", "00058", 
		"00065", "00073", "00079", "00117", "00130", "00136", "00192", "00173", "00174", "00175", 
		"00197", "00220", "00330", "00561", "00591", "00593", "00620", "00621", "00665", "00678", "00679", 
		"00702", "00721", "00723", "00725", "00729", "00740", "00743", "00826", "00852", "00901", 
		"00973", "00974", "00982", 
		"01033", "01738", "01761", "01762", "08798", "10289", "16135", "19196", "30214", "30324", "30657", "30658", 
		"30694", "31000", "31492", "71157", "71162", "72507", "72554", "72556", "72746", "73359", 
		"73460", "73580", "98002", "98004", "98012", "98027", "98502", "99001", "99003", "99004"];

$rubricasAT = ["00507", "00513"]; //rubricas abate-teto
$rubPagtosAdm = ["82174", "82175", "82176"]; //rubricas pagamento administrativo

$orgao = '40106'; //'57202';

$dataInicio = "21/07/1995"; //"01/01/1995";
$dataFinal = "01/07/1999";
$dataInicioPagtoAdm = "01/12/2002";
$dataFinalPagtoAdm = "01/08/2009";

$limitacaoContaDataObito = true;

//$dataObito = '21/10/1998';

$dataObito = '';
$percentualPagtosAdm = .8787;

//------------
// * fim
//------------


DadosExequente::buscarDadosExequente($arquivo); //uso apenas para efeito de testes

$dtobitoauxiliar = $dataObito;
$dataInicioAux = $dataInicio;
$proRata = false;

$today = date("d/m/Y");
$dataObito = ($dataObito == '' ? $today : $dataObito);

$dtObito = strtotime(str_replace("/","-",$dataObito));

//echo "Data de óbito: " . $dataObito . "<br>";

//verifica o cálculo do pro-rata
$dia = substr($dataInicio, 0,2);
$mesAno = substr($dataInicio, 2,8);

if ($dia <> "01"){
	$proRata = true;
	$proRataIndice = ((30 - intval($dia))+1)/30;	
	$dataInicio = "01" . $mesAno;
}



$rubricas = array_merge($rubricasAT, $rubPagtosAdm, $rubricasCalculo);
sort($rubricas);

list($filtrados, $periodos, $ocorrencias) = FiltragemPorRubricas::filtrar($arquivo, $rubricas, $rubricasAT, $dataInicio, $dataFinal);

list($pgtFiltrados, $pgtPeriodos, $pgtOcorrencias) = FiltragemPorRubricas::filtrar($arquivo, $rubPagtosAdm, $rubricasAT, $dataInicioPagtoAdm, $dataFinalPagtoAdm);


$mtzCalculo = MatrizDeCalculo::preencheMatrizCalculo($filtrados, $periodos, $orgao);
$mtzPgtosAdm = MatrizDeCalculo::preencheMatrizCalculo($pgtFiltrados, $pgtPeriodos, $orgao); 

$matrizCalculo317 = CalculoExequente::executaCalculo317($mtzCalculo, $periodos, $rubricasAT);
$matrizCalculoPgtoAdm = CalculoExequente::executaPagtosAdm($mtzPgtosAdm, $pgtPeriodos, $percentualPagtosAdm);


//echo json_encode($matrizCalculoPgtoAdm);

echo "<hr>";
echo "Dados do Processo:" . "<br>";
echo "<hr>";
echo "Órgão: " . $orgao . "<br>";
echo "Data de atualização: " . "<br>";
echo "Limitar a conta à data do óbito: SIM" . "<br>";
echo "Data de atualização: " . "<br>";

echo "Data de início: " . $dataInicioAux . "<br>";
echo "Data final: " . $dataFinal . "<br>";
echo "Data início pagamentos adm: " . $dataInicioPagtoAdm . "<br>";
echo "Data final pagamentos adm: " . $dataFinalPagtoAdm . "<br>";
echo "Data de óbito: " . $dtobitoauxiliar . "<br>";
echo "Percentual pagamento adm: " . $percentualPagtosAdm * 100 . "%" . "<br>";
echo "Rubricas utilizadas no cálculo: " . "<br>";
//echo "<hr>";

for ($i=0; $i < sizeof($rubricas); $i++) { 
	echo $rubricas[$i] . " : ";

}

echo "<hr>";
echo "Cálculo 3.17:";
echo "<hr>";



$Total317 = 0.0;

foreach ($matrizCalculo317 as $chave => $valor) {
	
	$dtPeriodo = strtotime(str_replace("/","-",$chave));

	if (($dtObito >= $dtPeriodo) and ($dtObito >= $dtPeriodo)) {
		
		echo $chave . "<br>" ;

		foreach ($valor as $key => $value) {
	  		echo $key . " ". $value . "<br>";
			
		}

		if ($proRata){
			$auxProRata = $valor['Soma'];			
			//$valor['Soma'] = $auxProRata * $proRataIndice;
			$valor['Valor Devido'] = $valor['Soma'] * 0.0317;
			$auxProRata = $valor['Valor Devido'] * $proRataIndice; ;
			$valor['Valor Devido'] = $auxProRata;

			echo "Pro-Rata: " . $proRataIndice . "<br>";
			echo "Valor Devido Pro-Rata: " . $valor['Valor Devido'] . "<br>";
			$proRata = false;
		}


		$Total317 += $valor['Valor Devido'];	  	
	  	
		
	}	
	echo "<hr>";
}

  		
echo "Sub-Total: ";
echo $Total317;
echo "<hr>";
	
echo "<br>";
echo "<hr>";
echo "Pagamentos Administrativos:";
echo "<hr>";

$PagtosAdm = 0.0;

foreach ($matrizCalculoPgtoAdm as $chave => $valor) {

	$dtPeriodo = strtotime(str_replace("/","-",$chave));

	if (($dtObito >= $dtPeriodo) and ($dtObito >= $dtPeriodo)) {
		
		echo $chave . "<br>" ;
		foreach ($valor as $key => $value) {
	  		echo $key . " ". $value . "<br>";	
		}
		echo "<hr>";
		$PagtosAdm += $valor['Valor Devido'];
	}	

}

echo "Total Pagtos Adm: ";
echo $PagtosAdm;
echo "<hr>";
echo "<br>";
echo "<br>";


echo "<hr>";	  		
echo "Sub-Total: ";
echo $Total317;
echo "<hr>";
echo "Pagtos Adm: ";
echo $PagtosAdm;
echo "<hr>";
echo "Total: ";
echo $Total317 - $PagtosAdm;
echo "<hr>";


?>