<?php

class Sarampo extends Tables {

    /*Função para contar os casos negativos de sarampo*/
    function CountSarampoPositivo($nametabelasinan, $get_pag, $conexaotable) {

        if(!empty($get_pag)):
            //Selecionar todos os casos da tabela com data de encerramento preenchida
            $sql = "SELECT NU_NOTIFIC FROM $nametabelasinan WHERE
            ID_DISTRIT='70' AND CLASSI_FIN=1 AND CRITERIO=1 AND ID_S1_IGM=1 OR
            ID_DISTRIT='70' AND CLASSI_FIN=1 AND CRITERIO=1 AND ID_S2_IGM=1 OR
            ID_DISTRIT='70' AND CLASSI_FIN=1 AND CRITERIO=1 AND ID_RE_IGM=1 OR
            ID_DISTRIT='70' AND CLASSI_FIN=1 AND CRITERIO=1 AND ID_ETIOLOG=1";
            $stm = $conexaotable->prepare($sql);
            $stm->execute(); //Contar o total de registros
            //Contar o total de registros
            $sqlcountsarampo = $stm->rowCount();

            if ($sqlcountsarampo >= 1) :
                return $sqlcountsarampo;
            else :
                return '0';
            endif;
        endif;

    }

    /*Função para contar os casos negativos de sarampo*/
    function CountSarampoNegativo($nametabelasinan, $get_pag, $conexaotable) {

        if(!empty($get_pag)):
            //Selecionar todos os casos da tabela com data de encerramento preenchida
            $sql = "SELECT NU_NOTIFIC FROM $nametabelasinan WHERE
            ID_DISTRIT='70' AND CLASSI_FIN=3 AND CRITERIO=1 AND ID_S1_IGM=2 OR
            ID_DISTRIT='70' AND CLASSI_FIN=3 AND CRITERIO=1 AND ID_S2_IGM=2 OR
            ID_DISTRIT='70' AND CLASSI_FIN=3 AND CRITERIO=1 AND ID_RE_IGM=2 OR
            ID_DISTRIT='70' AND CLASSI_FIN=3 AND CRITERIO=1";
            $stm = $conexaotable->prepare($sql);
            $stm->execute(); //Contar o total de registros
            //Contar o total de registros
            $sqlcountsarampo = $stm->rowCount();

            if ($sqlcountsarampo >= 1) :
                return $sqlcountsarampo;
            else :
                return '0';
            endif;
        endif;

    }

    /*Função para contar os casos negativos de sarampo*/
    function CountSarampoAnalise($nametabelasinan, $get_pag, $conexaotable, $get_year) {

        if(!empty($get_pag)):
            //Selecionar todos os casos da tabela com data de encerramento preenchida
            $sql = "SELECT NU_NOTIFIC FROM $nametabelasinan WHERE
            ID_DISTRIT='70' AND CLASSI_FIN < 1 AND CRITERIO < 1 AND DT_COL_1 LIKE '%$get_year%' OR
            ID_DISTRIT='70' AND CLASSI_FIN < 1 AND CRITERIO < 1 AND ID_URINA=1 OR
            ID_DISTRIT='70' AND CLASSI_FIN < 1 AND CRITERIO < 1 AND ID_SECRECA=1 OR
            ID_DISTRIT='70' AND CLASSI_FIN < 1 AND CRITERIO < 1 AND NOT DT_COL_1 LIKE '%$get_year%' OR
            ID_DISTRIT='70' AND CLASSI_FIN < 1 AND CRITERIO < 1 AND NOT DT_COL_2 LIKE '%$get_year%' OR
            ID_DISTRIT='70' AND CLASSI_FIN < 1 AND CRITERIO < 1 AND ID_SECRECA < 1 OR
            ID_DISTRIT='70' AND CLASSI_FIN < 1 AND CRITERIO < 1 AND ID_URINA < 1";
            $stm = $conexaotable->prepare($sql);
            $stm->execute(); //Contar o total de registros
            //Contar o total de registros
            $sqlcountsarampo = $stm->rowCount();

            if ($sqlcountsarampo >= 1) :
                return $sqlcountsarampo;
            else :
                return '0';
            endif;
        endif;

    }

}

/* Chamada de classe de formulário e classe de botões */
$sarampo = new Sarampo();