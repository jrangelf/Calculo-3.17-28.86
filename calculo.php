<?php

class CalculoExequente
{

    public static function agregarRubricas($mtzCalculo, $periodos){

        $mtzCalculoAgregada = [];

        foreach ($periodos as $periodo) {
            
            $tamRegistro = sizeof($mtzCalculo[$periodo]);
            $temporaria = [];
            
            //echo "<br>". $periodo . "<br>"; // DEBUG   
            //echo $tamanhoRegistro . "<br>";            
            
            for ($i=0; $i <= $tamRegistro-1 ; $i++) {           

                foreach ($mtzCalculo[$periodo][$i] as $chave => $valor) {

                    //echo $chave . " ". $valor . "<br>"; 

                    if (!array_key_exists($chave, $temporaria)) {
                                                    
                        $temporaria [$chave] = $valor;
                    
                    } else {
                        
                        
                        $auxiliar = (float)$temporaria[$chave]; // recebe o valor da chave duplicada                    
                        array_pop($temporaria);                        
                                                
                        $adiciona =  (float)$valor + (float)$auxiliar;
                                        
                        $temporaria [$chave] = (float)$adiciona;

                    }           
                
                }       

            }   
                /*
                echo "<br>";
                echo "CalculoExequente -> agregarRubricas: " . "<br>";
                echo json_encode($temporaria);
                echo "<hr>" . "<br>";
                */
                $mtzCalculoAgregada[$periodo] = $temporaria;
                
        }

        return $mtzCalculoAgregada;
    }


    public static function executaPagtosAdm($mtzPagtos, $periodos, $percentual){
        
        $matriz = self::agregarRubricas($mtzPagtos,$periodos);

        $rotuloSoma = 'Soma';
        $rotuloValorDevido = 'Valor Devido';      
        $rotuloPercentual = 'Percentual';        
                 
        /*echo "<hr>";
        echo json_encode($matriz) . "<br>";
        echo "<hr>";
        echo json_encode($periodos) . "<br>";
        echo "<hr>";*/               

        foreach ($matriz as $chave => $valor) {
            
            //echo $chave . "<br>" ;           
            $subsoma = 0.00;
            $soma = 0.00;
            $valordevido = 0.00;            

            foreach ($valor as $key => $value) {

                $aux = str_replace('.', '', $value);
                $aux = str_replace(',', '.', $aux);
                $soma += floatval($aux);                       
                                            
            }                    
                
            $matriz[$chave][$rotuloSoma]=$soma;
            $matriz[$chave][$rotuloPercentual]=$percentual;
            $matriz[$chave][$rotuloValorDevido]=$soma * $percentual;                        
            
        }     

        return $matriz;    
    }


    public static function executaCalculo317($mtzCalculo, $periodos, $rubricasAT){

        $matriz = self::agregarRubricas($mtzCalculo,$periodos);

        $rotuloSoma = 'Soma';
        $rotulo317 = '3,17 (%)';
        $rotuloValorDevido = 'Valor Devido';
        $mesDasFerias = '11';

        $rubricaFerias = ["00220"];
        $abateteto = false;
        $incideferias = false;
        $decimoterceiro = false;

        foreach ($matriz as $chave => $valor) {
            
            //echo $chave . "<br>" ;
            
            $subsoma = 0.00;
            $soma = 0.00;
            $valordevido = 0.00;
            $vlrferias = 0.00; 

            foreach ($valor as $key => $value) {                   
                
                if (substr($chave, 3, 2) == $mesDasFerias){
                    $decimoterceiro = true;         
                }
                
                // verifica se não é uma rubrica de abate-teto
                if (!in_array($key, $rubricasAT)) { 

                    // vefifica se é uma rubrica de adicional de ferias
                    if (!in_array($key, $rubricaFerias)){
                        
                        $aux = str_replace('.', '', $value);
                        $aux = str_replace(',', '.', $aux);
                        $subsoma += floatval($aux); 
                    } else {
                        // zerar a rubrica 00220                
                        $matriz[$chave][$key]=0;
                        $incideferias = true;               
                    }

                } else {

                    $abateteto = true;
                    // ordenar $valor;              
                }
                            
            }

            // iterou sobre todos os registro de mês
            if ($incideferias) {
                $incideferias = false;
                $vlrferias = $subsoma / 3;
                $matriz[$chave][$rubricaFerias[0]]=$vlrferias;
                
            }

            if (!$decimoterceiro){
                $soma = $subsoma + $vlrferias;

            } else {
                $soma = ($subsoma * 2) + $vlrferias;
                $decimoterceiro = false;
            }
            
            if ($abateteto){
                $abateteto = false;
                $soma = 0;
            } 
            
            $matriz[$chave][$rotuloSoma]=$soma;
            $matriz[$chave][$rotulo317]=0.0317;
            $matriz[$chave][$rotuloValorDevido]=$soma * 0.0317;            
            
        }

        return $matriz;
    }

    public static function executaCalculo2886($mtzCalculo, $periodos, $rubricasAT, $percentual, $segundoPercentual,$inicio2Percentual){

            $matriz = self::agregarRubricas($mtzCalculo,$periodos);

            //echo "<br>";
            //echo "matriz: " . "<br>";
            //echo json_encode($matriz);
            //echo "<hr>" . "<br>";


            $rotuloSoma = 'Soma';
            $rotulo2886 = '(%)';
            $rotuloValorDevido = 'Valor Devido';
            $mesDasFerias = '11';

            $rubricaFerias = ["00220"];
            $abateteto = false;
            $incideferias = false;
            $decimoterceiro = false;

            foreach ($matriz as $chave => $valor) {
                
                //echo $chave . "<br>" ;
                
                $subsoma = 0.00;
                $soma = 0.00;
                $valordevido = 0.00;
                $vlrferias = 0.00; 

                foreach ($valor as $key => $value) {                   
                    
                    if (substr($chave, 3, 2) == $mesDasFerias){
                        $decimoterceiro = true;         
                    }
                    
                    // verifica se não é uma rubrica de abate-teto
                    if (!in_array($key, $rubricasAT)) { 

                        // vefifica se é uma rubrica de adicional de ferias
                        if (!in_array($key, $rubricaFerias)){
                            
                            $aux = str_replace('.', '', $value);
                            $aux = str_replace(',', '.', $aux);
                            $subsoma += floatval($aux); 
                        } else {
                            // zerar a rubrica 00220                
                            $matriz[$chave][$key]=0;
                            $incideferias = true;               
                        }

                    } else {

                        $abateteto = true;
                        // ordenar $valor;              
                    }
                                
                }

                // iterou sobre todos os registro de mês
                if ($incideferias) {
                    $incideferias = false;
                    $vlrferias = $subsoma / 3;
                    $matriz[$chave][$rubricaFerias[0]]=$vlrferias;
                    
                }

                if (!$decimoterceiro){
                    $soma = $subsoma + $vlrferias;

                } else {
                    $soma = ($subsoma * 2) + $vlrferias;
                    $decimoterceiro = false;
                }
                
                if ($abateteto){
                    $abateteto = false;
                    $soma = 0;
                } 
                
                //echo "Chave de matriz: " . $chave . "<br>";

                if (($chave == $inicio2Percentual) and ($segundoPercentual <> 0) ){
                    $percentual = $segundoPercentual;
                }

                $matriz[$chave][$rotuloSoma]=$soma;
                $matriz[$chave][$rotulo2886]=$percentual;
                $matriz[$chave][$rotuloValorDevido]=$soma * $percentual;            
                
            }

            return $matriz;
        }




    
}   

?>