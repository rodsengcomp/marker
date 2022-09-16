<?php


class Aedes extends Tables {

    public $titleaedes;
    public $tabelasinan;

    /*Função para consultar a tabela do bd e após gera a senha de hash*/
    function countCasosNovosAedes($tabelasinan, $tabela, $conexao, $get_pag, $get_lixeira) {

        if(!empty($get_pag)):
            $sqlcountcasos = $conexao->query("SELECT COUNT(*) NU_NOTIFIC FROM $tabelasinan LEFT JOIN $tabela ON $tabelasinan.NU_NOTIFIC = $tabela.nu_sinan
                            WHERE ((($tabelasinan.ID_DISTRIT)='70') AND (($tabela.nu_sinan) Is Null))")->fetchColumn();
            if($sqlcountcasos == 1 && $get_lixeira <> 1) :
                return '<div class="alert alert-success text-center pt-1 pb-1" role="alert"><i class="fa fa-grin-beam me-2"></i><strong class="ms-1">NÃO EXISTEM NOVOS CASOS PARA ATUALIZAR !!!</strong>
                        </div>';
            elseif($sqlcountcasos > 1) :
                return '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-exclamation-circle me-2 "></i><strong>ATENÇÃO !!! </strong>
                            <a href="http://'.$host.'/'.$dbname.'/'.$pag_system.'?pag=edicao_endereco_dengue&pagina=1" class="alert-link">CLIQUE AQUI</a>. <strong class="ms-1">EXISTEM '.$sqlcountcasos.' NOVOS CASOS PARA ATUALIZAR !!!</strong>
                        </div>';
            else:

                return '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-exclamation-circle me-2"></i><strong>ATENÇÃO !!! </strong>
                            <a href="http://'.$host.'/'.$dbname.'/'.$pag_system.'?pag=edicao_endereco_aedes&pagina=1" class="alert-link">CLIQUE AQUI </a>. <strong class="ms-1">EXISTE '.$sqlcountcasos.' NOVO CASO PARA ATUALIZAR !!!</strong>
                        </div>';
            endif;
        endif;

    }
}