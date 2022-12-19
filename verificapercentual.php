<?php

class VerificacaoPercentual
{

    public static function calcularPercentuais($arquivo, $rubricasPercentual, $dataInicio, $dataFinal){   
       
        $json_a = json_decode($arquivo, true);

        //$tamExtracao = sizeof($json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros']);

        $tamExtracao = sizeof($json_a['dadosFinanceirosHistorico']);
    
        $vencJan = 0;
        $vencFev = 0;
        $vencMar = 0;
        $vencJul = 0;
        $vencSet = 0;

        $vencimento = 0;
        $percentual = 0;
        $segundoPercentual = 0;
        $delta = 0;  

        for ($x = 0; $x <= $tamExtracao-1; $x++) {
      
          //$codOrgao = $json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros'][$x]['codigoOrgao'];
          //$mesAnoPagto = $json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros'][$x]['mesAnoPagamento'];


          $codOrgao = $json_a['dadosFinanceirosHistorico'][$x]['codigoOrgao'];
          $mesAnoPagto = $json_a['dadosFinanceirosHistorico'][$x]['mesAnoPagamento'];
          
          //echo "Data (dataInicio): " . $dataInicio . "<br>";          
          //echo "Data (dataFinal): " . $dataFinal . "<br>";

          $inicio = strtotime(str_replace("/","-",$dataInicio)); 
          $final = strtotime(str_replace("/","-",$dataFinal)); 
        
          $dataReg = AjustaDatas::converteData ($mesAnoPagto);
          $dataReg = strtotime(str_replace("/","-",$dataReg));

          $JAN1993 = AjustaDatas::converteData ("01/01/1993");
          $JAN1993 = strtotime(str_replace("/","-",$JAN1993));          
          $FEV1993 = AjustaDatas::converteData ("01/02/1993");
          $FEV1993 = strtotime(str_replace("/","-",$FEV1993));
          $MAR1993 = AjustaDatas::converteData ("01/03/1993");
          $MAR1993 = strtotime(str_replace("/","-",$MAR1993));
          $JUL1998 = AjustaDatas::converteData ("01/07/1998");
          $JUL1998 = strtotime(str_replace("/","-",$JUL1998));
          $SET1998 = AjustaDatas::converteData ("01/09/1998");
          $SET1998 = strtotime(str_replace("/","-",$SET1998));

          //echo "Órgão: " . $codOrgao . "<br>";
          //echo "mesAnoPagto: " . $mesAnoPagto . "<br>";
          //echo "dataReg: " . $dataReg . "<br>";
          //echo "----------------------------------------------------------------------------" . "<br>";
          //echo "Data: " . $mesAnoPagto . "<br>";
          //echo "----------------------------------------------------------------------------" . "<br>";          
          //echo "Data (inicio) : " . $inicio . "<br>";          
          //echo "Data (final): " . $final . "<br>";
          //echo "----------------------------------------------------------------------------" . "<br>";
          
          if ($dataReg >= $inicio  && $dataReg <= $final){
      
            //$tamFicha = sizeof($json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros'][$x]['dadosFinanceiros']['DadosFinanceiros']);

            $tamFicha = sizeof($json_a['dadosFinanceirosHistorico'][$x]['dadosFinanceiros']['DadosFinanceiros']);            
            
            // obtém os maiores vencimentos de jan, fev e mar de 1993 e jul e set de 1998
            for ($y = 0; $y <= $tamFicha-1; $y++) {

              //$codigoRubrica = $json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros'][$x]['dadosFinanceiros']['DadosFinanceiros'][$y]['codRubrica'];

              //$valorRubrica = $json_a['dadosFinanceirosHistorico']['ArrayDadosFinanceiros'][$x]['dadosFinanceiros']['DadosFinanceiros'][$y]['valorRubrica'];


              $codigoRubrica = $json_a['dadosFinanceirosHistorico'][$x]['dadosFinanceiros']['DadosFinanceiros'][$y]['codRubrica'];

              $valorRubrica = $json_a['dadosFinanceirosHistorico'][$x]['dadosFinanceiros']['DadosFinanceiros'][$y]['valorRubrica'];

              //echo "Rubrica: " . $codigoRubrica . "<br>";
              //echo "----------------------------------------------------------------------------" . "<br>";
              //echo "Valor rubrica: " . $valorRubrica . "<br>";
              //echo "----------------------------------------------------------------------------" . "<br>";

              if (in_array($codigoRubrica, $rubricasPercentual)){

                  //echo "Órgão: " . $codOrgao . "<br>";
                  //echo "mesAnoPagto: " . $mesAnoPagto . "<br>";
                  //echo "Rubrica: " . $codigoRubrica . "<br>";                 
                  //echo "Valor rubrica: " . $valorRubrica . "<br>";
                  //echo "----------------------------------------------------------------------------" . "<br>";

                  if ($dataReg = $JAN1993) {              
                    if ($vencJan = 0){                 
                      $vencJan = $valorRubrica;
                    } 
                    else {
                      if ($valorRubrica > $vencJan){                    
                          $vencJan = $valorRubrica;
                      }
                    }          
                  }   
                                   
                  if ($dataReg = $FEV1993) {              
                    if ($vencFev = 0){                 
                      $vencFev = $valorRubrica;
                    } 
                    else {
                      if ($valorRubrica > $vencFev){                    
                          $vencFev = $valorRubrica;
                      }
                    }          
                  }                  

                  if ($dataReg = $MAR1993) {              
                    if ($vencMar = 0){                 
                      $vencMar = $valorRubrica;
                    } 
                    else {
                      if ($valorRubrica > $vencMar){                    
                          $vencMar = $valorRubrica;
                      }
                    }          
                  }                 

                  if ($dataReg = $JUL1998) {              
                    if ($vencJul = 0){                 
                      $vencJul = $valorRubrica;
                    } 
                    else {
                      if ($valorRubrica > $vencJul){                    
                          $vencJul = $valorRubrica;
                      }
                    }          
                  }
                  
                  if ($dataReg = $SET1998) {              
                    if ($vencSet = 0){                 
                      $vencSet = $valorRubrica;
                    } 
                    else {
                      if ($valorRubrica > $vencSet){                    
                          $vencSet = $valorRubrica;
                      }
                    }          
                  }                  

              } // end if

            } // end for

          } // end if
        
        } //end for        

        $vencJan = (float)$vencJan;
        $vencFev = (float)$vencFev;
        $vencMar = (float)$vencMar;
        $vencJul = (float)$vencJul;
        $vencSet = (float)$vencSet;

        echo "----------------------------------------------------------------------------" . "<br>"; 
        echo "VencJan 1993: " . $vencJan . "<br>";
        echo "VencFev 1993: " . $vencFev . "<br>";
        echo "VencMar 1993: " . $vencMar . "<br>";
        echo "VencJul 1998: " . $vencJul . "<br>";
        echo "VencSet 1998: " . $vencSet . "<br>";
        echo "----------------------------------------------------------------------------" . "<br>";
        
        if ($vencFev <> 0) {
          
          $delta = ((($vencMar - $vencFev) / $vencFev)) + 1;
        }
        
        
        if ((($vencJan == 0) and ($vencFev == 0)) or ($vencFev == $vencMar) or ($vencFev > $vencMar)) {
          $delta = 1;    
        }    
   
        if ($delta == 0){
          $delta = 1;
        }
                
        if ($delta > 1.75){          
          $p1 = $delta / 1.33;          
          
          if ($p1 > 1.2886){
            $delta = 1.2886;
          }
        }

           
        if ($delta > 1.2886){
            $p1 = $delta/1.33;
            $delta = $p1;
        }               
   
        $diferenca = 1.2886 / $delta;
        $percentual = $diferenca - 1;

        //echo "delta= " . $delta . "<br>";
        //echo "----------------------------------------------------------------------------" . "<br>"; 
  
        //echo "Diferença = 1,2886 / Delta = " . $diferenca . "<br>";
        //echo "----------------------------------------------------------------------------" . "<br>";     
        //echo  "Percentual = " . $percentual*100 ." %". "<br>";
        //echo "=============================================================================" . "<br>";
      
        if ($percentual >= 0.2886){
          $percentual = 0;
        }

        $delta = 0;
        $diferenca = 0;

        if ($vencJul <> 0){
          $delta = $vencSet / $vencJul;          
        }
        
        if ($delta == 0){
           $delta = 1;
        }

        $diferenca= 1 / $delta;
        $segundoPercentual = $diferenca - 1;


        if (($segundoPercentual > 0.2886) or ($segundoPercentual < 0)){
          $segundoPercentual =0;
        }

        //echo "Diferença = 1 / Delta (%) = " . $diferenca . "<br>";
        //echo "----------------------------------------------------------------------------" . "<br>";
      
        //echo  "Segundo Percentual = " . $segundoPercentual*100 ." %". "<br>";
        //echo "=============================================================================" . "<br>";
   
        return [$percentual, $segundoPercentual];
        
    }    


} 

?>



