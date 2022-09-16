<?php
error_reporting(-1);

include_once 'Conexao.php';

date_default_timezone_set('America/Sao_Paulo'); // DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
$ano_atual = date('Y'); // CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
$ano_anterior = $ano_atual - 1;

$get_pag = isset($_GET['pagina']) ? $_GET['pagina'] : ''; // Recebe o ano de listagem se existir
$get_lixeira = isset($_GET['lixeira']) ? $_GET['lixeira'] : 0; // Recebe o termo de pesquisar se existir
$get_hash = isset($_GET['hash']) ? $_GET['hash'] : ''; // Recebe o termo de pesquisar se existir
$get_sv2 = isset($_GET['sv2']) ? $_GET['sv2'] : 'suvis'; // Recebe o termo de pesquisar se existir
$get_livro = isset($_GET['livro']) ? $_GET['livro'] : ''; // Recebe o termo de pesquisar se existir
$get_year = isset($_GET['ano']) ? $_GET['ano'] : $ano_atual;
$get_id = isset($_GET['id']) ? $_GET['id'] : ''; // Recebe o termo de pesquisar se existir

$conexao = conexao::getInstance();

$id_system = 1;

$sqlsystem = 'SELECT id, description, author, title, icon, sistema, versao, direitos, desenvolvedor, email_contato, ano, pag_principal, unidade_name FROM config_system WHERE id = :id';
$stmsystem = $conexao->prepare($sqlsystem);
$stmsystem->bindValue(':id', $id_system);
$stmsystem->execute();
$systemfetch = $stmsystem->fetch(PDO::FETCH_OBJ);

$sql = 'SELECT id, name_pag, name_form, caminho, caminho_serverside, tabela, tabelasinan, tabelaexameccz, tabelaexameial, agravo, unidade FROM pag_system WHERE name_pag = :name_pag';
$stm = $conexao->prepare($sql);
$stm->bindValue(':name_pag', $get_pag);
$stm->execute();
$retorno = $stm->execute();
$pags = $stm->fetch(PDO::FETCH_OBJ);

    // If para trazer o nome das tabelas do sistema, as configurações com nome das tabelas está disponível na tabela pag_system do banco "sisdam",
    // as tabelas são : sinannet e gal-ial se houverem (banco sisdam para tabelas do ano atual, banco sisdam_arq para tabelas de anos anteriores)

if(!empty(is_numeric($get_year)) && $get_year > 2015 && $get_year < $ano_atual):
    $conexaotable = conexao::getInstanceArquive();
    if(!empty($pags->tabela)):
        $nametabela = $pags->tabela.'_'.$get_year;
    endif;
    if(!empty($pags->tabelasinan)):
        $nametabelasinan = $pags->tabelasinan.'_'.$get_year;
    endif;
    if(!empty($pags->tabelaexameccz)):
        $nametabelaexameccz = $pags->tabelaexameccz.'_'.$get_year;
    endif;
    if(!empty($pags->tabelaexameial)):
        $nametabelaexameial = $pags->tabelaexameial.'_'.$get_year;
    endif;
else:
    $conexaotable = conexao::getInstance();
    if(!empty($pags->tabela)):
        $nametabela = $pags->tabela;
    endif;
    if(!empty($pags->tabelasinan)):
        $nametabelasinan = $pags->tabelasinan;
    endif;
    if(!empty($pags->tabelaexameccz)):
        $nametabelaexameccz = $pags->tabelaexameccz;
    endif;
    if(!empty($pags->tabelaexameial)):
        $nametabelaexameial = $pags->tabelaexameial;
    endif;
endif;

if(!empty($pags->caminho_serverside)):
    $nameserverside = $pags->caminho_serverside;
endif;

if(!empty($pags->agravo)):
    $nameagravo = $pags->agravo;
endif;

if(!empty($pags->name_form)):
    $nameform = $pags->name_form;
endif;

$stm = null;

class Tables {

    var $ano_atual;
    var $sql;
    var $stm;
    var $fetch;
    var $edit;

    static function queryEdit($conexaotable, $nametabela, $id) {
        // Consulta os dados da tabela para edição
        $sql = "SELECT * FROM $nametabela WHERE id = :id";
        $stm = $conexaotable->prepare($sql);
        $stm->bindValue(':id', $id);
        return $stm->execute();
    }

    // Lista todos os registros >>>
    static function query($conexaotable, $nameselect, $nametabela, $namewhere) {

        // Consulta os dados no banco - PDOStatement
        $sql = "SELECT $nameselect FROM $nametabela WHERE $namewhere";
        $stm = $conexaotable->prepare($sql);

        // Resultados de lista
        return $stm->execute();
    }

    // Lista todos os registros >>>
    static function queryListAll($conexaotable, $nameselect, $nametabela, $namewhere, $order) {

        // Consulta os dados no banco - PDOStatement
        $sql = "SELECT $nameselect FROM $nametabela WHERE $namewhere $order";
        $stm = $conexaotable->prepare($sql);
        $stm->execute();

        // Resultados de lista
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    // Lista todos os registros >>>
    static function queryList($conexaotable, $nameselect, $nametabela, $namewhere, $order) {

        // Consulta os dados no banco - PDOStatement
        $sql = "SELECT $nameselect FROM $nametabela WHERE $namewhere $order";
        $stm = $conexaotable->prepare($sql);
        $stm->execute();

        // Resultados de lista
        return $stm->fetch(PDO::FETCH_OBJ);
    }

    // Lista todos os registros >>>
    static function queryListAllArray($conexaotable, $nameselect, $nametabela, $namewhere, $order, $id) {

        // Consulta os dados no banco - PDOStatement
        $sql = "SELECT $nameselect FROM $nametabela WHERE $namewhere $order";
        $stm = $conexaotable->prepare($sql);
        $stm->execute(array($id));;

        // Resultados de lista
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    // Função para contar dados em tabela
    static function queryCountNumber($get_pag, $conexaotable, $nametabela, $select_table_count_number, $where_count_namber) {

        // Condição para verificar se o get da página está vazio ou ...
        if(!empty($get_pag)):

            $sql = "SELECT $select_table_count_number FROM $nametabela WHERE $where_count_namber"; // Seleciona os parâmetros passados no objeto para consulta
            $stm = $conexaotable->prepare($sql); // Prepara a consulta
            $stm->execute(); // Executa a consulta
            $sql_count_number = $stm->rowCount(); //Contar o total de registros encontrados

            // Condição para resultado de consulta rowCount
            if ($sql_count_number >= 1) :
                return $sql_count_number;
            else :
                return 0;
            endif;

        endif;

    }

    // Lista todos os registros <<<

    static function ErrorEdit($id, $get_year) {
        if (!empty($id) && is_numeric($id)):
            if (!empty(is_numeric($get_year)) && $get_year == $ano_atual):
                return header("Location: $pag_system?pagina=$get_pag");
            elseif (!is_numeric($get_year < $ano_atual)) :
                return header("Location: $pag_system?pagina=$get_pag&ano=$get_year");
            else :
                return $_SESSION['msgerro'] = '<div class="alert alert-danger text-center text-uppercase" role="alert">
                <strong>ERRO AO EDITAR: DOCUMENTO COM O Nº : ' . $id . ' - ' . $get_year . ' - NÃO ENCONTRADO !!!</strong></div>';
            endif;
        endif;
    }

    // Função para mostrar data de criação de tabela (dia e horário)
    static function DateCreationTable($nametabela, $conexaotable) {

        //Selecionar a data de criação da tabela em formato de hora americano
        $sql = "SELECT CREATE_TIME FROM information_schema.tables WHERE `TABLE_NAME`=:TABLE_NAME ORDER BY `CREATE_TIME` DESC LIMIT 1";
        $stm = $conexaotable->prepare($sql);
        $stm->bindValue(':TABLE_NAME', $nametabela);
        $stm->execute();
        $row_sinan = $stm->fetch(PDO::FETCH_OBJ);
        $createsinan = $row_sinan->CREATE_TIME;
        $datetable = date("d/m/Y H:i:s",strtotime($createsinan));
        $datetableday = date("d/m/Y",strtotime($createsinan));
        $datenow = date("d/m/Y");

        if($datetableday <> $datenow):
            return '<strong class="text-danger">'.$datetable.'</strong>';
        elseif($datetableday >= $datenow):
            return '<strong class="text-success">'.$datetable.'</strong>';
        else:
            return '<strong class="text-warning">'.$datetable.'</strong>';
        endif;
    }

    /* Função para consultar a tabela do bd e após gera a senha de hash*/
    static function listphp($nametabela, $get_lixeira, $get_pag, $conexaotable) {

            if(!empty($get_pag)):
                $sql = "SELECT * FROM $nametabela WHERE lixeira=:lixeira";
                $stm = $conexaotable->prepare($sql);
                $stm->bindValue(':lixeira', $get_lixeira);
                $stm->execute();
                return $stm->fetchAll(PDO::FETCH_OBJ);
            endif;
    }

    static function ListServer($get_year, $nameserverside, $nametabela, $nametabelasinan, $nametabelaexameccz, $nametabelaexameial, $get_pag, $get_livro, $get_lixeira) {
        if(!empty($get_pag)):
            return $nameserverside.'?tabela='.$nametabela.'&tabelasinan='.$nametabelasinan.'&tabelaccz='.$nametabelaexameccz.'&tabelaial='.$nametabelaexameial.'&ano='.$get_year.'&livro='.$get_livro.'&getlixeira='.$get_lixeira;
        endif;
    }

    /*Função para consultar a tabela do bd e após gera a senha de hash*/
    static function countCasosNovos($get_lixeira, $nametabelasinan, $nametabela, $conexaotable, $get_pag, $usuarioniveldeacesso, $pag_system, $get_year, $ano_atual) {

        if(!empty($get_pag)):

            //Selecionar todos os casos da tabela
            $sql = "SELECT $nametabelasinan.NU_NOTIFIC FROM $nametabelasinan LEFT JOIN $nametabela ON $nametabelasinan.NU_NOTIFIC = $nametabela.nu_sinan 
            WHERE ((($nametabelasinan.ID_DISTRIT)='70') AND (($nametabela.nu_sinan) Is Null))";
            $stm = $conexaotable->prepare($sql);
            $stm->execute(); //Contar o total de registros
            //Contar o total de registros
            $sqlcountcasos = $stm->rowCount();

            if(substr($get_pag, 0,6) === 'listar'):
                $lista = substr($get_pag, 6);
                if($get_lixeira === 1) :
                    return '';
                elseif($sqlcountcasos >= 1 && $usuarioniveldeacesso <= 2) :
                    if(!empty($get_year < $ano_atual)):
                        return '<div class="alert alert-danger text-center pt-1 pb-1" role="alert"><i class="fa fa-exclamation-circle me-2"></i><strong>ATENÇÃO !!! </strong>
                                <a href="'.$pag_system.'?pagina=editar'.$lista.'&ano='.$get_year.'&registro=1" role="button" class="alert-link">CLIQUE AQUI </a>. <strong>
                        EXISTE '.$sqlcountcasos.' NOVO CASO PARA ATUALIZAR !!!</strong></div>';
                    else:
                        return '<div class="alert alert-danger text-center pt-1 pb-1" role="alert"><i class="fa fa-exclamation-circle me-2"></i><strong>ATENÇÃO !!! </strong>
                                <a href="'.$pag_system.'?pagina=editar'.$lista.'&registro=1" role="button" class="alert-link">CLIQUE AQUI </a>. <strong>
                        EXISTE '.$sqlcountcasos.' NOVO CASO PARA ATUALIZAR !!!</strong></div>';
                    endif;
                elseif($sqlcountcasos < 1 && $usuarioniveldeacesso >= 1 && $usuarioniveldeacesso < 3):
                    return '<div class="alert alert-success text-center pt-1 pb-1" role="alert"><i class="fa fa-grin-beam-sweat me-2"></i><strong>
                            NÃO EXISTEM NOVOS CASOS PARA ATUALIZAR !!!</strong></div>';
                else:
                    return '';
                endif;
            endif;
        endif;

    }

    /*Função para consultar a tabela do bd e após gera a senha de hash*/
    function BancoAtual($createccz, $createsinan, $get_year, $ano_atual, $get_lixeira) {
        if ($get_lixeira === 1):
                return '<div class="bd-callout text-center text-secondary"><strong><a href="http://sinan.saude.gov.br/sinan/login/login.jsf" class="link-secondary" target="_blank">DengueOnLine</a> de</strong> : ' .date("d/m/Y", strtotime($createsinan)). ' <strong> às </strong>'
                    .date("H:i:s", strtotime($createsinan)) . ' - <strong><a href="https://matrixbi.matrixsaude.com/labzoo_xview_mx/che-login.aspx?ReturnUrl=%2flabzoo_xview_mx%2fcon-pagina-inicial.aspx" class="link-secondary" target="_blank">Resultados de Exame CCZ</a> de </strong> : '
                    .date("d/m/Y", strtotime($createccz)) . '<strong> às </strong>' .date("H:i:s", strtotime($createccz)) . '</div>';
            elseif ($get_year === $ano_atual):
                return '<div class="bd-callout text-center text-primary"><strong><a href="http://sinan.saude.gov.br/sinan/login/login.jsf" class="link-primary" target="_blank">DengueOnLine</a> de</strong> : ' .date("d/m/Y", strtotime($createsinan)). ' <strong> às </strong>'
                    .date("H:i:s", strtotime($createsinan)) . ' - <strong><a href="https://matrixbi.matrixsaude.com/labzoo_xview_mx/che-login.aspx?ReturnUrl=%2flabzoo_xview_mx%2fcon-pagina-inicial.aspx" class="link-primary" target="_blank">Resultados de Exame CCZ</a> de </strong> : '
                    .date("d/m/Y", strtotime($createccz)) . '<strong> às </strong>' .date("H:i:s", strtotime($createccz)) . '</div>';
        else:
            return '<div class="bd-callout text-center text-danger"><strong><a href="http://sinan.saude.gov.br/sinan/login/login.jsf" class="link-danger" target="_blank">DengueOnLine</a> de</strong> : ' .date("d/m/Y", strtotime($createsinan)). ' <strong> às </strong>'
                .date("H:i:s", strtotime($createsinan)) . ' - <strong><a href="https://matrixbi.matrixsaude.com/labzoo_xview_mx/che-login.aspx?ReturnUrl=%2flabzoo_xview_mx%2fcon-pagina-inicial.aspx" class="link-danger" target="_blank">Resultados de Exame CCZ</a> de </strong> : '
                .date("d/m/Y", strtotime($createccz)) . '<strong> às </strong>' .date("H:i:s", strtotime($createccz)) . '</div>';
        endif;
    }

    /*Função para consultar a tabela do bd e após gera a senha de hash*/
    function countLixeiraAedes($nametabela, $nametabelasinan, $conexaotable, $get_pag) {

        if(!empty($get_pag)):
            $sql = "SELECT lixeira FROM $nametabela INNER JOIN $nametabelasinan ON $nametabela.nu_sinan = $nametabelasinan.NU_NOTIFIC  WHERE lixeira=1";
            $stm = $conexaotable->prepare($sql);
            $stm->execute(); //Contar o total de registros
            //Contar o total de registros
            $sqlcountlixo = $stm->rowCount();

            if ($sqlcountlixo >= 1) :
                return $sqlcountlixo;
            else :
                return 'VAZIA';
            endif;
        endif;

    }

    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }



}