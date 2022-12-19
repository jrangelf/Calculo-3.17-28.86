<?php

include ("ajustadatas.php");
include ("dadosexequente.php");
include ("filtragem.php");
include ("geramatrizcalculo.php");
include ("verificapercentual.php");
include ("calculo.php");

$DEBUG = true;
$DEBUG1 = false;

//-----------------------------------------------------------------------------------------------------------
// * INÍCIO - dados serão enviados pelo front-end 
//-----------------------------------------------------------------------------------------------------------
//$arquivo = file_get_contents('/Users/rangel/317tst/24733830904.json'); //arquivo de extração do exequente

$nomedoarquivo = "26544962104-consulta1.json"; 

$arquivo = file_get_contents('/Users/rangel/dadosSiape/' . $nomedoarquivo);

//$arquivo = file_get_contents('/Users/rangel/317tst/teste24733830904.json'); 
//$arquivo = file_get_contents('/Users/rangel/dadosSiape/09901957168-consulta1.json');
//$arquivo = file_get_contents('/Users/rangel/dadosSiape/26544962104-consulta1.json');

//03470741387-consulta2.json

//$arquivo = file_get_contents('/Users/rangel/317tst/00460001000.json');
//$arquivo = file_get_contents('/Users/rangel/317tst/29167817068.json');
//$arquivo = file_get_contents('/Users/rangel/317tst/88961770730.json');
//$arquivo = file_get_contents('/Users/rangel/317tst/47799234091.json');
//$arquivo = file_get_contents('/Users/rangel/317tst/24733830904.json');



// rubricas utilizada no cálculo- retirar a 00176 - Gratificação Natalina.
$rubricasCalculoC = 
	[	"00001", "00005", "00009", "00012", "00013", "00016", "00018", "00028", "00029", "00031", 
		"00034", "00036", "00037", "00038", "00039", "00040", "00041", "00050", "00053", "00064", 
		"00065", "00067", "00071", "00080", "00087", "00107", "00120", "00137", "00147", "00153", 
		"00174", "00175", "00159", "00162", "00163", "00167", "00175", "00188", "00189", "00196",
		"00199", "00221", "00222", "00222", "00243", "00244", "00249", "00252", "00253", "00254",
		"00270", "00279", "00287", "00298", "00356", "00358", "00359", "00414", "00415", "00469",
		"00482", "00517", "00518", "00523", "00524", "00528", "00529", "00537", "00538", "00549",
		"00577", "00591", "00592", "00602", "00604", "00611", "00631", "00657", "00679", "00686",
		"00703", "00705", "00706", "00708", "00713", "00758", "00760", "00761", "00777", "00778",
		"00780", "00781", "00782", "00784", "00806", "00809", "00812", "00817", "00819", "00855",
		"00883", "00884", "00885", "00886", "00887", "00888", "00894", "00895", "00902", "00964",
		"00991", "01259", "01260", "01419", "01421", "01435", "01438", "01454", "01469", "01476",
		"01485", "01619", "01778", "01779", "01785", "01801", "02086", "02186", "02405", "02406",
		"02551", "02858", "03100", "03104", "03105", "03106", "03108", "03303", "03396", "03405",
		"03417", "03573", "03574", "03575", "03576", "03707", "03717", "03795", "04013", "04023",
		"04025", "04031", "04073", "04089", "04090", "04173", "04195", "04199", "04201", "04202",
		"04205", "04766", "04767", "04928", "05036", "05046", "05076", "05077", "06641", "08187",
		"09060", "10092", "14494", "19241", "20000", "82051", "82066", "82067", "82082", "82083",
		"82101", "82102", "82104", "82109", "82114", "82156", "82157", "82158", "82163", "82178",
		"82183", "82213", "82215", "82217", "82318", "82334", "82374", "82462", "82502", "82526",
		"82558", "82604", "82607", "82915", "82921", "82922"];

$rubricasCalculoR = 
	[	"00240", "00241", "00246"];


$rubricasCalculoF = 
	[	"00004", "00015", "00024", "00025", "00032", "00060", "00070", "00078", "00117", "00173", 
	    "00174", "00256", "00360", "00416", "00515", "00522", "00560", "00561", "00585", "00593",
	    "00610", "00612", "00613", "00620", "00621", "00622", "00702", "00719", "00720", "00721",
	    "00722", "00723", "00724", "00725", "00726", "00727", "00728", "00729", "00730", "00731",
	    "00732", "00733", "00734", "00735", "00736", "00737", "00738", "00739", "00740", "00757",
	    "00852", "00901", "00903", "00904", "00905", "00912", "00981", "00982", "82070"];


$rubPagtosAdm2886 = 
	[	"00955", "00956", "00957", "00984", "01248", "01343", "01344", "01467", "01549", "01571",
		"01572", "01640", "08030", "10230", "17001", "19994", "82240", "97068", "97195", "97196",
		"97461"]; 


$rubricasAT = 
	[	"00507", "00513", "00507", "00513", "00556", "00557", "00558", "00594", "00595", "00665",
		"00666", "03408", "09470", "11114", "14680", "14681", "14705", "14706", "16004", "16005",
		"82282", "82839" ]; 


$rubricasPercentual = ["00001","00005"];

$orgao = '40106'; //'57202';
$dataAjuizamento = '';
$dataCitacao = '';
$dataAtualizacao = '';


$dataInicioC = "15/09/1993"; //"01/01/1995";
$dataFinalC = "30/06/1998";

$dataInicioF = "15/09/1993"; //"01/01/1995";
$dataFinalF = "30/06/1998";

$dataInicioR = "15/09/1993"; //"01/01/1995";
$dataFinalR = "30/06/1998";

$dataInicioPagtoAdm = "01/05/1999";
$dataFinalPagtoAdm = "01/12/2005";

$inicio2Percentual = "01/07/1998";

$limitacaoContaDataObito = true;

$dataObito = ''; // 21/10/1998';
$percentualPagtosAdm = 1;


//-----------------------------------------------------------------------------------------------------------
// * FIM  - dados enviados pelo front end
//-----------------------------------------------------------------------------------------------------------


DadosExequente::buscarDadosExequente($arquivo); //uso apenas para efeito de testes

$dtobitoauxiliar = $dataObito;

$dataInicioSemProRataC = $dataInicioC;
$dataInicioSemProRataF = $dataInicioF;
$dataInicioSemProRataR = $dataInicioR;

$proRataC = false;
$proRataF = false;
$proRataR = false;

$today = date("d/m/Y");
$dataObito = ($dataObito == '' ? $today : $dataObito);
$dtObito = strtotime(str_replace("/","-",$dataObito));

//echo "Data de óbito: " . $dataObito . "<br>";

list($proRataIndiceC, $dataInicioC) = AjustaDatas::calcularProRata($dataInicioC);
list($proRataIndiceR, $dataInicioR) = AjustaDatas::calcularProRata($dataInicioR);
list($proRataIndiceF, $dataInicioF) = AjustaDatas::calcularProRata($dataInicioF);

if ($DEBUG){
	echo "pro-rata C: " . $proRataIndiceC . "<br>";
	echo "nova data C: " . $dataInicioC . "<br>";
	echo "pro-rata F: " . $proRataIndiceF . "<br>";
	echo "nova data F: " . $dataInicioF . "<br>";
	echo "pro-rata R: " . $proRataIndiceR . "<br>";
	echo "nova data R: " . $dataInicioR . "<br>";
}

if ($proRataIndiceC <> 0) {$proRataC = true;}
if ($proRataIndiceF <> 0) {$proRataF = true;}
if ($proRataIndiceR <> 0) {$proRataR = true;}	


list ($percentual2886, $segundoPercentual) = VerificacaoPercentual::calcularPercentuais($arquivo, $rubricasPercentual, $dataInicioC, $dataFinalC);

//$segundoPercentual = 0.1568;

if ($DEBUG){
	echo "----------------------------------------------------------------------------" . "<br>";
	echo  "Percentual = " . $percentual2886*100 ." %". "<br>";
	echo  "Segundo Percentual = " . $segundoPercentual*100 ." %". "<br>";
	echo "----------------------------------------------------------------------------" . "<br>";
}


$rubricas = array_merge($rubricasAT, $rubPagtosAdm2886, $rubricasCalculoC);
sort($rubricas);
list($filtradosC, $periodosC, $ocorrenciasC) = FiltragemPorRubricas::filtrar($arquivo, $rubricas, $rubricasAT, $dataInicioC, $dataFinalC);


$rubricas = array_merge($rubricasAT, $rubricasCalculoF);
//$rubricas = array_merge($rubricasCalculoF);
sort($rubricas);
list($filtradosF, $periodosF, $ocorrenciasF) = FiltragemPorRubricas::filtrar($arquivo, $rubricas, $rubricasAT, $dataInicioF, $dataFinalF);


$rubricas = array_merge($rubricasCalculoR);
sort($rubricas);
list($filtradosR, $periodosR, $ocorrenciasR) = FiltragemPorRubricas::filtrar($arquivo, $rubricas, $rubricasAT, $dataInicioR, $dataFinalR);



list($pgtFiltrados, $pgtPeriodos, $pgtOcorrencias) = FiltragemPorRubricas::filtrar($arquivo, $rubPagtosAdm2886, $rubricasAT, $dataInicioPagtoAdm, $dataFinalPagtoAdm);


$mtzCalculoC = MatrizDeCalculo::preencheMatrizCalculo($filtradosC, $periodosC, $orgao);
$matrizCalculo2886C = CalculoExequente::executaCalculo2886($mtzCalculoC, $periodosC, $rubricasAT,$percentual2886,$segundoPercentual,$inicio2Percentual);

$mtzCalculoF = MatrizDeCalculo::preencheMatrizCalculo($filtradosF, $periodosF, $orgao);
$matrizCalculo2886F = CalculoExequente::executaCalculo2886($mtzCalculoF, $periodosF, $rubricasAT,$percentual2886,$segundoPercentual,$inicio2Percentual);

$mtzCalculoR = MatrizDeCalculo::preencheMatrizCalculo($filtradosR, $periodosR, $orgao);
$matrizCalculo2886R = CalculoExequente::executaCalculo2886($mtzCalculoR, $periodosR, $rubricasAT,$percentual2886,$segundoPercentual,$inicio2Percentual);


$mtzPgtosAdm = MatrizDeCalculo::preencheMatrizCalculo($pgtFiltrados, $pgtPeriodos, $orgao); 
$matrizCalculoPgtoAdm = CalculoExequente::executaPagtosAdm($mtzPgtosAdm, $pgtPeriodos, $percentualPagtosAdm);


//echo json_encode($matrizCalculoPgtoAdm);

//------------------------------------------------------------------------------------------------
// * INÍCIO - apresentação do resultado do cálculo será feito pelo front-end 
//------------------------------------------------------------------------------------------------
echo "<hr>";
echo "Dados do Processo:" . "<br>";
echo "<hr>";
echo "Órgão: " . $orgao . "<br>";
echo "Data de atualização: " . "<br>";
echo "Limitar a conta à data do óbito: SIM" . "<br>";
echo "Data de atualização: " . "<br>";
echo "----------------------------------------------------------------------------" . "<br>";
echo "Data de início (C): " . $dataInicioSemProRataC . "<br>";
echo "Data final (C): " . $dataFinalC . "<br>";
echo "Data de início (F): " . $dataInicioSemProRataF . "<br>";
echo "Data final (F): " . $dataFinalF . "<br>";
echo "Data de início (R): " . $dataInicioSemProRataR . "<br>";
echo "Data final (R): " . $dataFinalR . "<br>";
echo "----------------------------------------------------------------------------" . "<br>";
echo "Data início pagamentos adm: " . $dataInicioPagtoAdm . "<br>";
echo "Data final pagamentos adm: " . $dataFinalPagtoAdm . "<br>";
echo "Data de óbito: " . $dtobitoauxiliar . "<br>";
echo "Percentual pagamento adm: " . $percentualPagtosAdm * 100 . "%" . "<br>";
echo "----------------------------------------------------------------------------" . "<br>";

if ($DEBUG1){

	echo "Rubricas de CARGO: " . "<br>";
	for ($i=0; $i < sizeof($rubricasCalculoC); $i++) { 
		echo $rubricasCalculoC[$i] . " : ";
	}
	echo "<br>";

	echo "----------------------------------------------------------------------------" . "<br>";
	echo "Rubricas de FUNÇÃO: " . "<br>";
	for ($i=0; $i < sizeof($rubricasCalculoF); $i++) { 
		echo $rubricasCalculoF[$i] . " : ";
	}
	echo "<br>";

	echo "----------------------------------------------------------------------------" . "<br>";
	echo "Rubricas de RAV: " . "<br>";
	for ($i=0; $i < sizeof($rubricasCalculoR); $i++) { 
		echo $rubricasCalculoR[$i] . " : ";
	}
	echo "<br>";

	echo "----------------------------------------------------------------------------" . "<br>";
	echo "Rubricas de Pagamentos Administrativos: " . "<br>";
	for ($i=0; $i < sizeof($rubPagtosAdm2886); $i++) { 
		echo $rubPagtosAdm2886[$i] . " : ";
	}
	echo "<br>";

	echo "----------------------------------------------------------------------------" . "<br>";
	echo "Rubricas de Abate Teto: " . "<br>";
	for ($i=0; $i < sizeof($rubricasAT); $i++) { 
		echo $rubricasAT[$i] . " : ";
	}
	echo "<br>";
	echo "----------------------------------------------------------------------------" . "<br>";


}

echo "<hr>";
echo "Cálculo 28.68 - CARGO:";
echo "<hr>";

$Total2886C = 0.0;

foreach ($matrizCalculo2886C as $chave => $valor) {
	
	$dtPeriodo = strtotime(str_replace("/","-",$chave));

	if (($dtObito >= $dtPeriodo) and ($dtObito >= $dtPeriodo)) {
		
		echo $chave . "<br>" ;

		foreach ($valor as $key => $value) {
	  		echo $key . " ". $value . "<br>";
			
		}

		if ($proRataC){
			$auxProRata = $valor['Soma'];			
			//$valor['Soma'] = $auxProRata * $proRataIndice;
			$valor['Valor Devido'] = $valor['Soma'] * $percentual2886;
			$auxProRata = $valor['Valor Devido'] * $proRataIndiceC; ;
			$valor['Valor Devido'] = $auxProRata;

			echo "Pro-Rata: " . $proRataIndiceC . "<br>";
			echo "Valor Devido Pro-Rata: " . $valor['Valor Devido'] . "<br>";
			$proRataC = false;
		}


		$Total2886C += $valor['Valor Devido'];	  	
	  	
		
	}	
	echo "<hr>";
}
  		
echo "Sub-Total CARGO: ";
echo $Total2886C;
echo "<hr>";




echo "<hr>";
echo "Cálculo 28.68 - FUNÇÃO:";
echo "<hr>";

$Total2886F = 0.0;

foreach ($matrizCalculo2886F as $chave => $valor) {
	
	$dtPeriodo = strtotime(str_replace("/","-",$chave));

	if (($dtObito >= $dtPeriodo) and ($dtObito >= $dtPeriodo)) {
		
		echo $chave . "<br>" ;

		foreach ($valor as $key => $value) {
	  		echo $key . " ". $value . "<br>";
			
		}

		if ($proRataF){
			$auxProRata = $valor['Soma'];			
			//$valor['Soma'] = $auxProRata * $proRataIndice;
			$valor['Valor Devido'] = $valor['Soma'] * $percentual2886;
			$auxProRata = $valor['Valor Devido'] * $proRataIndiceF; ;
			$valor['Valor Devido'] = $auxProRata;

			echo "Pro-Rata: " . $proRataIndiceF . "<br>";
			echo "Valor Devido Pro-Rata: " . $valor['Valor Devido'] . "<br>";
			$proRataF = false;
		}


		$Total2886F += $valor['Valor Devido'];	  	
	  	
		
	}	
	echo "<hr>";
}
  		
echo "Sub-Total FUNÇÃO: ";
echo $Total2886F;
echo "<hr>";




echo "<hr>";
echo "Cálculo 28.68 - RAV:";
echo "<hr>";

$Total2886R = 0.0;

foreach ($matrizCalculo2886R as $chave => $valor) {
	
	$dtPeriodo = strtotime(str_replace("/","-",$chave));

	if (($dtObito >= $dtPeriodo) and ($dtObito >= $dtPeriodo)) {
		
		echo $chave . "<br>" ;

		foreach ($valor as $key => $value) {
	  		echo $key . " ". $value . "<br>";
			
		}

		if ($proRataR){
			$auxProRata = $valor['Soma'];			
			//$valor['Soma'] = $auxProRata * $proRataIndice;
			$valor['Valor Devido'] = $valor['Soma'] * $percentual2886;
			$auxProRata = $valor['Valor Devido'] * $proRataIndiceR; ;
			$valor['Valor Devido'] = $auxProRata;

			echo "Pro-Rata: " . $proRataIndiceR . "<br>";
			echo "Valor Devido Pro-Rata: " . $valor['Valor Devido'] . "<br>";
			$proRataR = false;
		}

		$Total2886R += $valor['Valor Devido'];  	
		
	}

	echo "<hr>";
}

  		
echo "Sub-Total RAV: ";
echo $Total2886R;
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

//------------------------------------------------------------------------------------------------
// * FIM - apresentação do resultado do cálculo será feito pelo front-end 
//------------------------------------------------------------------------------------------------

/*
echo "<hr>";	  		
echo "Sub-Total: ";
echo $Total317;
echo "<hr>";
echo "Pagtos Adm: ";
echo $PagtosAdm;
echo "<hr>";
echo "Total: ";
echo $Total317 - $PagtosAdm;
echo "<hr>";ß


echo "<hr>";
echo "Cálculo 28.68 - FUNÇÃO:";
echo "<hr>";


echo "<hr>";
echo "Cálculo 28.68 - RAV:";
echo "<hr>";
*/

//echo "<br>";
//echo "matriz: " . "<br>";
//echo json_encode($mtzCalculoR);
//echo "<hr>" . "<br>";




?>