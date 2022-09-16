<?php

include_once 'Tables.php';

$usuarioniveldeacesso = isset($_SESSION['usuarioNivelAcesso']) ? $_SESSION['usuarioNivelAcesso'] : 4;
$usuarioid = isset($_SESSION['usuarioId']) ? $_SESSION['usuarioId'] : 1;

class Buttons extends Tables {

    public $title;
    public $namelist;

    static function language() {
            echo '"language": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros","sInfoEmpty": "Mostrando 0 até 0 de 0 registros","sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoThousands": ".","sLengthMenu": "_MENU_ Resultados por Página","sLoadingRecords": "Carregando...","sProcessing": "Processando...","sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar","oPaginate": {"sNext": "Próximo","sPrevious": "Anterior","sFirst": "Primeiro","sLast": "Último"},
                "oAria": {"sSortAscending": "Ordenar colunas de forma ascendente","sPrevious": "Ordenar colunas de forma descendente"} }';
    }

    static function ButtonDataTable($nameform, $get_year, $system) {

        $i_excel = '<i class="fal fa-file-excel"></i>';
        $i_pdf = '<i class="fal fa-file-pdf"></i>';
        $i_print = '<i class="fal fa-print"></i>';
        $i_list = '<i class="fal fa-list"></i>';

        return "buttons: [ {extend:'excel',title:'$system - $nameform - $get_year',header: '$system - $nameform - $get_year',filename:'$system - $nameform - $get_year',className: 'btn btn-outline-success',text:'$i_excel' },
                {extend: 'pdfHtml5',exportOptions: {columns: ':visible'},title:'$system - $nameform - $get_year',header: '$system - $nameform - $get_year',filename:'$system - $nameform - $get_year',orientation: 'landscape',pageSize: 'LEGAL',className: 'btn btn-outline-danger',text:'$i_pdf'},
                {extend:'print', exportOptions: {columns: ':visible'},title:'$system - $nameform - $get_year',header: '$system - $nameform - $get_year',filename:'$system - $nameform - $get_year',orientation:'landscape',className: 'btn btn-outline-secondary',text:'$i_print'},
                {extend:'colvis',titleAttr: 'Select Colunas',className: 'btn btn-outline-primary',text:'$i_list'} ]";
    }

    static function AlertSession() {

        /** @var msgsuccess $_SESSION */
        if (isset($_SESSION['msgsuccess'])) :
            echo $_SESSION['msgsuccess'];
            unset($_SESSION['msgsuccess']);
        endif;

        /** @var msgdanger $_SESSION */
        if (isset($_SESSION['msgdanger'])) :
            echo $_SESSION['msgdanger'];
            unset($_SESSION['msgdanger']);
        endif;

        /** @var msgwarning $_SESSION */
        if (isset($_SESSION['msgwarning'])) :
            echo $_SESSION['msgwarning'];
            unset($_SESSION['msgwarning']);
        endif;

        /** @var msgerro $_SESSION */
        if (isset($_SESSION['msgerro'])) :
            echo $_SESSION['msgerro'];
            unset($_SESSION['msgerro']);
        endif;

        /** @var msgedit $_SESSION */
        if (isset($_SESSION['msgedit'])) :
            echo $_SESSION['msgedit'];
            unset($_SESSION['msgedit']);
        endif;

        /** @var msgdel $_SESSION */
        if (isset($_SESSION['msgdel'])) :
            echo $_SESSION['msgdel'];
            unset($_SESSION['msgdel']);
        endif;
    }

    static function NavDataTable($data_icon, $data_text) {
        return '<div class="row mt-4 pe-3">
                    <div class="col-md-12 ml-auto"><nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><i class="'.$data_icon.' me-2"></i><strong>'.$data_text.'</strong></li>
                        </ol>
                    </div>
                </div>';
    }

    static function BtnColor($get_lixeira, $get_year, $ano_atual) {
        if ($get_lixeira == 1):
            return 'secondary';
        elseif($get_year < $ano_atual):
            return 'danger';
        elseif($get_year == $ano_atual):
            return 'primary';
        else:
            return 'success';
        endif;
    }

    static function BtnColorListSv2($get_lixeira, $get_year, $ano_atual, $get_livro) {
        if ($get_lixeira == 1):
            return 'secondary';
        elseif($get_year < $ano_atual):
            return 'danger';
        elseif($get_year === $ano_atual && $get_livro === 'covid'):
            return 'dark';
        else:
            return 'primary';
        endif;
    }

    static function BtnColorSv2($get_sv2) {
        if ($get_sv2 === 'suvis'):
            return 'success';
        elseif ($get_sv2 === 'outros'):
            return 'danger';
        elseif ($get_sv2 === 'covid'):
            return 'dark';
        elseif ($get_sv2 === 'covid-outros'):
            return 'dark';
        elseif ($get_sv2 === 'siva'):
            return 'secondary';
        elseif ($get_sv2 === 'siva-outros'):
            return 'secondary';
        elseif ($get_sv2 === 'surto'):
            return 'primary';
        else:
            return 'success';
        endif;
    }

    static function BtnColorStyle($get_lixeira, $get_year, $ano_atual) {
        if ($get_lixeira == 1):
            return '#6c757d';
        elseif($get_year < $ano_atual):
            return '#dc3545';
        elseif($get_year == $ano_atual):
            return '#0d6efd';
        else:
            return '#6c757d';
        endif;
    }

    static function FaList($get_lixeira, $get_year, $ano_atual) {
        if ($get_lixeira == 1):
            return 'trash-o';
        elseif ($get_year < $ano_atual):
            return 'list';
        else:
            return 'list';
        endif;
    }

    static function BtnTitleList($get_pag, $get_year, $nameform, $ano_atual, $get_lixeira) {
        if(!empty($get_pag)):
            if($get_year == $ano_atual && $get_lixeira == 1) :
                echo '<div class="d-grid gap-2 mb-3"><button disabled type="button" class="btn btn-outline-secondary btn-md btn-block fw-bold mb-2"><i class="fa fa-trash-o px-2"></i>
                        LIXEIRA DE '.$nameform.' - '.$get_year.'</button>';
            elseif($get_year < $ano_atual && 1 == $get_lixeira) :
                echo '<div class="d-grid gap-2 mb-3"><button disabled type="button" class="btn btn-outline-secondary btn-md btn-block fw-bold mb-2"><i class="fa fa-trash-o px-2"></i>
                        LIXEIRA DE ARQUIVO DE '.$nameform.' - '.$get_year.'</button>';
            elseif ($ano_atual == $get_year && $get_lixeira == 0) :
                echo '<div class="d-grid gap-2 mb-3"><button disabled type="button" class="btn btn-outline-primary btn-md btn-block fw-bold mb-2"><i class="fal fa-list px-2"></i>
                       LISTA DE '.$nameform.' - '.$get_year.'</button>';
            else:
                echo '<div class="d-grid gap-2 mb-3"><button disabled type="button" class="btn btn-outline-danger btn-md btn-block fw-bold mb-2"><i class="fal fa-list px-2"></i>
                       ARQUIVO DE LISTA DE '.$nameform.' - '.$get_year.'</button>';
            endif;
        endif;
    }

    static function BtnBlockTitle($btn_color, $nameicon, $nametitle, $nameform) {
        return '<div class="d-grid mb-3">
                    <button disabled type="button" class="btn btn-outline-'.$btn_color.' btn-md btn-block fw-bold">
                        <i class="fal fa-'.$nameicon.' px-2"></i> '.$nametitle.' '.$nameform.'
                    </button>
                </div>';
    }

    static function BtnCadlist($get_year, $ano_atual, $usuarioid, $pag_system, $get_pag) {

        $cadastro = substr($get_pag, 6);

        if(!empty($get_pag)):
            if ($get_year === $ano_atual && $usuarioid > 1) :
                return '<a href = "'.$pag_system.'?pagina=cadastrar'.$cadastro.'&ano='.$ano_atual.'" type = "button" class="btn btn-outline-success btn-sm fw-bold mb-3 me-3"
                accesskey="N" data-toggle="tooltip" data-placement="bottom" title="CADASTRAR"><i class="fal fa-plus-circle px-2"></i><u>N</u>OVO</a>';
            endif;
        endif;
    }

    static function BtnGravar($usuarioid, $usuariostatus, $usuarioniveldeacesso){
            if ($usuarioid === 1):
            return '';
            elseif ($usuariostatus === 0):
                return '';
            elseif ($usuarioniveldeacesso === 4):
                return '';
            else:
                return '<button type="submit" accesskey="G" data-toggle="tooltip" title="GRAVAR OS DADOS" class="btn btn-outline-success btn-sm fw-bold mb-2 me-2 mr-sm-4">
                            <i class="fal fa-compact-disc me-2"></i><u>G</u>RAVAR </button>';
            endif;
    }

    static function BtnPrintMemo($id, $tipo, $get_year){
        return '<a target="_blank" href="sistema/impressao/memorandos-e-oficios/imprimir-memorandos-e-oficios?id='.$id.'&tipo='.$tipo.'&ano='.$get_year.'" tabindex="-1" target="_blank" data-toggle="tooltip" title="IMPRIMIR" aria-disabled="true" role="button" class="btn btn-outline-secondary btn-sm btn-circle mb-2 me-2 mr-sm-4"><i class="fa fa-print-search"></i></a>';
    }

    static function BtnSair($pag_system) {
        return '<a href="'.$pag_system.'" role="button" data-toggle="tooltip" title="SAIR DO FORMULÁRIO" accesskey="S" class="btn btn-outline-danger btn-sm fw-bold mb-2 mr-sm-4"><i class="fal fa-reply-all me-2"></i ><u>S</u>AIR</a>';
    }

    static function BtnListarSv2($pag_system,$get_pag, $get_year, $get_sv2) {

        if(substr($get_pag, 0,9) === 'cadastrar'):
            $lista = substr($get_pag, 9);
        else:
            $lista = substr($get_pag, 6);
        endif;

        if(substr($get_sv2, 0,5) === 'covid'):
            return '<a href="'.$pag_system.'?pagina=listar'.$lista.'&livro=covid&ano='.$get_year.'" role="button" data-toggle="tooltip" title="LISTAR REGISTROS"
                    accesskey="L" class="btn btn-outline-info btn-sm fw-bold mb-2 me-2 mr-sm-4"><i class="fa fa-list-ol me-2"></i><u>L</u>ISTAR</a>';
        else:
        return '<a href="'.$pag_system.'?pagina=listar'.$lista.'&ano='.$get_year.'" role="button" data-toggle="tooltip" title="LISTAR REGISTROS"
                    accesskey="L" class="btn btn-outline-info btn-sm fw-bold mb-2 me-2 mr-sm-4"><i class="fa fa-list-ol me-2"></i><u>L</u>ISTAR</a>';
        endif;
    }

    static function BtnListar($pag_system,$get_pag, $get_year, $ano_atual) {

        if(substr($get_pag, 0,9) === 'cadastrar'):
            $lista = substr($get_pag, 9);
        else:
            $lista = substr($get_pag, 6);
        endif;

        if(!empty($get_year < $ano_atual)):
            return '<a href="'.$pag_system.'?pagina=listar'.$lista.'&ano='.$get_year.'" role="button" data-toggle="tooltip" title="LISTAR REGISTROS"
            accesskey="L" class="btn btn-outline-info btn-sm fw-bold mb-2 me-2 mr-sm-4"><i class="fa fa-list-ol me-2"></i><u>L</u>ISTAR</a>';
        else:
            return '<a href="'.$pag_system.'?pagina=listar'.$lista.'" role="button" data-toggle="tooltip" title="LISTAR REGISTROS"
            accesskey="L" class="btn btn-outline-info btn-sm fw-bold mb-2 me-2 mr-sm-4"><i class="fa fa-list-ol me-2"></i><u>L</u>ISTAR</a>';
        endif;
    }

    static function BtnLink($link, $accesskey, $btncolor, $img, $icon, $u, $name) {
        return '<a href="'.$link.'" accesskey="'.$accesskey.'" target="_blank" 
                role="button" class="btn btn-outline-'.$btncolor.' btn-sm fw-bold mb-2 me-2 mr-sm-4">'
                .$img.' <i class="fa fa-'.$icon.' me-2"></i> <u>'.$u.'</u>'.$name.' </a>';
    }

    /*Função para verificar se o usuário esta cadastrado no sistema e após Ok, */
    static function Hash($usuariologin) {
        if (!empty($usuariologin)) {
            return sha1(md5($usuariologin));
        }
    }

    static function BtnModalLixo($usuarioid, $usuariostatus, $usuarioniveldeacesso) {
        if ($usuarioid === 1):
            return '';
        elseif ($usuariostatus === 0):
            return '';
        elseif ($usuarioniveldeacesso === 4):
            return '';
        else:
            return '<button type="button" title="APAGAR" class="btn btn-outline-danger btn-sm btn-circle mb-2 me-2 mr-sm-4" data-toggle="modal" data-target="#modalLixeira">
                        <i class="fa fa-trash-o" data-toggle="tooltip" title="LIXEIRA"></i></button>';
        endif;
    }

    static function Btnlistlixeira($usuarioniveldeacesso,$get_lixeira, $get_year, $get_pag, $nu_lixeira, $pag_system) {
        if ($usuarioniveldeacesso == 1):
            if ($get_lixeira == 0):
                return '<a href="'.$pag_system .'?pagina='.$get_pag.'&ano='.$get_year.'&lixeira=1" role="button" accesskey="L" class="btn btn-outline-secondary btn-sm fw-bold mb-3"
                        data-toggle="tooltip" data-placement="bottom" title="LIXEIRA"><i class="fa fa-trash-o px-2"></i><u>L</u>IXO <span class="badge rounded-pill bg-danger">' . $nu_lixeira . '</a>';
            else:
                return '<a href="' . $pag_system . '?pagina='.$get_pag.'&ano='.$get_year.'" accesskey="S" role="button" class="btn btn-outline-danger btn-sm fw-bold mb-3"><i class="fa fa-arrow-circle-o-left px-2"></i><u>S</u>AIR</a>';
            endif;
        endif;
    }

    static function BtnlistlixeiraAedes($usuarioniveldeacesso,$get_lixeira, $get_year, $get_pag, $nu_lixeiraedes, $pag_system) {
        if ($usuarioniveldeacesso == 1):
            if ($get_lixeira == 0):
                return '<a href="'.$pag_system .'?pagina='.$get_pag.'&ano='.$get_year.'&lixeira=1" role="button" class="btn btn-outline-secondary btn-sm fw-bold mb-3"
                        data-toggle="tooltip" data-placement="bottom" title="LIXEIRA"><i class="fa fa-trash-o px-2"></i><u>L</u>IXO <span class="badge rounded-pill bg-danger">' . $nu_lixeiraedes . '</a>';
            else:
                return '<a href="' . $pag_system . '?pagina='.$get_pag.'&ano='.$get_year.'" accesskey="S" role="button" class="btn btn-outline-danger btn-sm fw-bold mb-3"><i class="fa fa-arrow-circle-o-left px-2"></i><u>S</u>AIR</a>';
            endif;
        endif;
    }



    /** Função para alertar quando não existem registros na lixeira */
    static function AlertLixeira ($get_lixeira, $nu_lixeira) {
        if ('VAZIA' === $nu_lixeira && $get_lixeira == 1) :
            return '<div class="alert alert-danger text-center text-uppercase pt-1 pb-1 mt-2" role="alert"><i class="fa fa-recycle"></i>
                <strong>A LIXEIRA ESTÁ VAZIA !!!</strong></div>';
        endif;
    }

    /** Função para alertar quando não existem registros na lixeira */
    static function AlertLixeiraAedes ($get_lixeira, $nu_lixeiraedes) {
        if ($nu_lixeiraedes === 'VAZIA' && 1 == $get_lixeira) :
            return '<div class="alert alert-danger text-center text-uppercase pt-1 pb-1 mt-2" role="alert"><i class="fa fa-recycle"></i>
                <strong>A LIXEIRA ESTÁ VAZIA !!!</strong></div><br>';
        endif;
    }

    /** Função para alertar quando não existem registros na tabela ou a lixeira está está vazia
     * @param $nu_registro // Se retornado no $_GET como 1 exibe a lista da lixeira
     */
    static function AlertSemRegistros($nu_registro) {
        if($nu_registro == 0) :
            return '<div class="alert alert-danger text-center text-uppercase pt-1 pb-1 mt-2" role="alert"><i class="fa fa-grimace me-2"></i>
                <strong>NÃO EXISTEM DOCUMENTOS CADASTRADOS !!!</strong></div>';
        endif;

    }

    static function mes ($i){
        switch ($i) {
            case "01": return "janeiro";
            case "02": return "fevereiro";
            case "03": return "março";
            case "04": return "abril";
            case "05": return "maio";
            case "06": return "junho";
            case "07": return "julho";
            case "08": return "agosto";
            case "09": return "setembro";
            case "10": return "outubro";
            case "11": return "novembro";
            case "12": return "dezembro";
            default: return "mes não encontrado";

        }
    }

    static function memoficio ($mo){
        switch ($mo) {
            case "0": return "Memorando";
            case "1": return "Ofício";
            default: return "Não encontrado";
        }
    }
}