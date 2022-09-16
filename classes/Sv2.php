<?php
error_reporting(-1);

class Sv2 extends Tables {

    static function NameFormSv2($get_sv2, $get_pag) {

        if($get_pag === 'cadastrar-sv2'):
            $get_pag_form = 'cadastro_sv2';
        else:
            $get_pag_form = 'edicao_sv2';
        endif;

        if ($get_sv2 === 'suvis'):
            return $get_pag_form;
        elseif ($get_sv2 === 'covid'):
            return $get_pag_form.'_covid';
        elseif ($get_sv2 === 'covid-outros'):
            return $get_pag_form.'_covid_outros';
        elseif ($get_sv2 === 'outros'):
            return $get_pag_form.'_outros';
        elseif ($get_sv2 === 'siva'):
            return $get_pag_form.'_siva';
        elseif ($get_sv2 === 'siva-outros'):
            return $get_pag_form.'_siva_outros';
        elseif ($get_sv2 === 'surto'):
            return $get_pag_form.'_surto';
        else:
            return $get_pag_form;
        endif;
    }

    static function ReadonlySv2($get_sv2) {
        // Captura $_GET php sobre agravo para bloquear preenchimento dos
        // campos "cep, log, bairro, ubs ref, atual?, uvis, cidade e da"
        // através do recurso html5 "readonly"

        if ($get_sv2 === 'suvis'):
            return 'readonly';
        elseif ($get_sv2 === 'covid'):
            return 'readonly';
        elseif ($get_sv2 === 'siva'):
            return 'readonly';
        elseif ($get_sv2 === 'surto'):
            return 'readonly';
        else:
            return '';
        endif;
    }

    static function AgravoSinanSv2($get_sv2) {
        // Habilita busca autocomplete com a função Javascript "Typehead"
        // -> https://twitter.github.io/typeahead.js/examples/

        if ($get_sv2 === 'siva'):
            return 'agravosiva';
        elseif ($get_sv2 === 'siva-outros'):
            return 'agravosiva';
        elseif ($get_sv2 === 'surto'):
            return 'agravosurto';
        elseif ($get_sv2 === 'covid'):
            return 'agravocovid';
        elseif ($get_sv2 === 'covid-outros'):
            return 'agravocovid';
        else:
            return 'agravo';
        endif;
    }

    /*Função para consultar a tabela do bd e após gera a senha de hash*/
    function SemRegistroSv2($get_pag, $nametabela, $get_livro, $conexaotable) {

        // Inicia a conexao
        if(!empty($get_pag)):
            if($get_livro === 'covid'):
                return $conexaotable->query("SELECT COUNT(1) FROM $nametabela WHERE agravo LIKE 'COVID-19%'")->fetchColumn();
            else:
                return $conexaotable->query("SELECT COUNT(1) FROM $nametabela WHERE agravo NOT LIKE 'COVID-19%'")->fetchColumn();
            endif;
        endif;
    }

    static function HeaderListSv2($get_sv2, $pag_system, $get_year, $get_lixeira) {
        if (!empty($get_sv2 === 'covid') && $get_lixeira == 1):
            return header("Location: $pag_system?pagina=listar-sv2&livro=covid&lixeira=1&ano=$get_year");
        elseif (!empty($get_sv2 === 'covid-outros')  && $get_lixeira == 1):
            return header("Location: $pag_system?pagina=listar-sv2&livro=covid&lixeira=1&ano=$get_year");
        elseif (!empty($get_sv2 === 'covid')):
            return header("Location: $pag_system?pagina=listar-sv2&livro=covid&ano=$get_year");
        elseif (!empty($get_sv2 === 'covid-outros')):
            return header("Location: $pag_system?pagina=listar-sv2&livro=covid&ano=$get_year");
        elseif (!empty($get_lixeira == 1)):
            return header("Location: $pag_system?pagina=listar-sv2&lixeira=1&ano=$get_year");
        else:
            return header("Location: $pag_system?pagina=listar-sv2&ano=$get_year");
        endif;
    }

    static function RuaSv2Edit($get_sv2, $rua) {
        if ($get_sv2 === 'suvis'):
            return '<input type="text" tabindex="11" class="form-control form-control-sm rua" name="rua" data-toggle="tooltip" title="Ex: Francisco Rodrigues ..." id="ruaselect"
                       placeholder="NOME DO ENDEREÇO" onchange="upperCaseF(this)" value="'.$rua.'">';
        elseif ($get_sv2 === 'covid'):
            return '<input type="text" tabindex="11" class="form-control form-control-sm rua" name="rua" data-toggle="tooltip" title="Ex: Francisco Rodrigues ..." id="ruaselect"
                       placeholder="NOME DO ENDEREÇO" onchange="upperCaseF(this)" value="'.$rua.'">';
        elseif ($get_sv2 === 'siva'):
            return '<input type="text" tabindex="11" class="form-control form-control-sm rua" name="rua" data-toggle="tooltip" title="Ex: Francisco Rodrigues ..." id="ruaselect"
                       placeholder="NOME DO ENDEREÇO" onchange="upperCaseF(this)" value="'.$rua.'">';
        elseif ($get_sv2 === 'surto'):
            return '<input type="text" tabindex="11" class="form-control form-control-sm rua" name="rua" data-toggle="tooltip" title="Ex: Francisco Rodrigues ..." id="ruaselect"
                       placeholder="NOME DO ENDEREÇO" onchange="upperCaseF(this)" value="'.$rua.'">';
        else:
            return '<input type="text" class="form-control form-control-sm" data-toggle="tooltip" title="Ex: Francisco Rodrigues ..." name="rua" placeholder="NOME DO ENDEREÇO"
                        onchange="upperCaseF(this)" value="'.$rua.'">';
        endif;
    }

    static function RuaSv2($get_sv2) {
        if ($get_sv2 === 'suvis'):
            return '<input type="text" tabindex="11" class="form-control form-control-sm rua" name="rua" data-toggle="tooltip" title="Ex: Francisco Rodrigues ..." id="ruaselect"
                       placeholder="NOME DO ENDEREÇO" onchange="upperCaseF(this)">';
        elseif ($get_sv2 === 'covid'):
            return '<input type="text" tabindex="11" class="form-control form-control-sm rua" name="rua" data-toggle="tooltip" title="Ex: Francisco Rodrigues ..." id="ruaselect"
                       placeholder="NOME DO ENDEREÇO" onchange="upperCaseF(this)">';
        elseif ($get_sv2 === 'siva'):
            return '<input type="text" tabindex="11" class="form-control form-control-sm rua" name="rua" data-toggle="tooltip" title="Ex: Francisco Rodrigues ..." id="ruaselect"
                       placeholder="NOME DO ENDEREÇO" onchange="upperCaseF(this)">';
        elseif ($get_sv2 === 'surto'):
            return '<input type="text" tabindex="11" class="form-control form-control-sm rua" name="rua" data-toggle="tooltip" title="Ex: Francisco Rodrigues ..." id="ruaselect"
                       placeholder="NOME DO ENDEREÇO" onchange="upperCaseF(this)">';
        else:
            return '<input type="text" class="form-control form-control-sm" data-toggle="tooltip" title="Ex: Francisco Rodrigues ..." name="ruaoutros" placeholder="NOME DO ENDEREÇO"
                        onchange="upperCaseF(this)">';
        endif;
    }


    static function BtnListLixeiraSv2($usuarioniveldeacesso,$get_lixeira, $get_year, $get_pag, $nu_lixeira, $pag_system, $get_livro) {
        if ($usuarioniveldeacesso === 1):
            if ($get_lixeira === 0 && $get_livro === 'covid'):
                return '<a href="'.$pag_system .'?pagina='.$get_pag.'&livro=covid&ano='.$get_year.'&lixeira=1" role="button" accesskey="L" class="btn btn-outline-dark btn-sm fw-bold mb-3"
                        data-toggle="tooltip" data-placement="bottom" title="LIXEIRA"><i class="fa fa-trash-o px-2"></i><u>L</u>IXO <span class="badge rounded-pill bg-danger">' . $nu_lixeira . '</a>';
            elseif ($get_lixeira === 0 && $get_livro === ''):
                return '<a href="'.$pag_system .'?pagina='.$get_pag.'&ano='.$get_year.'&lixeira=1" role="button" accesskey="L" class="btn btn-outline-secondary btn-sm fw-bold mb-3"
                    data-toggle="tooltip" data-placement="bottom" title="LIXEIRA"><i class="fa fa-trash-o px-2"></i><u>L</u>IXO <span class="badge rounded-pill bg-danger">' . $nu_lixeira . '</a>';
            elseif($get_lixeira == 1 && $get_livro === 'covid'):
                return '<a href="' . $pag_system . '?pagina='.$get_pag.'&livro=covid&ano='.$get_year.'" accesskey="S" role="button" class="btn btn-outline-danger btn-sm fw-bold mb-3"><i class="fa fa-arrow-circle-o-left px-2"></i><u>S</u>AIR</a>';
            elseif($get_lixeira == 1 && $get_livro === ''):
                return '<a href="' . $pag_system . '?pagina='.$get_pag.'&ano='.$get_year.'" accesskey="S" role="button" class="btn btn-outline-danger btn-sm fw-bold mb-3"><i class="fa fa-arrow-circle-o-left px-2"></i><u>S</u>AIR</a>';
            endif;
        endif;
    }

    static function BtnCadListSv2($get_year, $ano_atual, $usuarioid, $pag_system, $get_pag, $get_livro) {

        $cadastro = substr($get_pag, 7);

        if(!empty($get_pag)):
            if ($get_year === $ano_atual && $usuarioid > 1 && $get_livro === 'covid') :
                return '<a href = "'.$pag_system.'?pagina=cadastrar-'.$cadastro.'&sv2=covid&ano='.$ano_atual.'" type = "button" class="btn btn-outline-success btn-sm fw-bold mb-3 me-3"
                accesskey="N" data-toggle="tooltip" data-placement="bottom" title="CADASTRAR"><i class="fal fa-plus-circle px-2"></i><u>N</u>OVO</a>';
            elseif ($get_year === $ano_atual - 1 && $usuarioid > 1 && $get_pag === 'listar-sv2') :
                return '<a href = "'.$pag_system.'?pagina=cadastrar-'.$cadastro.'&sv2=suvis&ano='.$get_year.'" type = "button" class="btn btn-outline-success btn-sm fw-bold mb-3 me-3"
            accesskey="N" data-toggle="tooltip" data-placement="bottom" title="CADASTRAR"><i class="fal fa-plus-circle px-2"></i><u>N</u>OVO</a>';
            else:
                return '<a href = "'.$pag_system.'?pagina=cadastrar-'.$cadastro.'&sv2=suvis&ano='.$ano_atual.'" type = "button" class="btn btn-outline-success btn-sm fw-bold mb-3 me-3"
            accesskey="N" data-toggle="tooltip" data-placement="bottom" title="CADASTRAR"><i class="fal fa-plus-circle px-2"></i><u>N</u>OVO</a>';
            endif;
        endif;
    }

    static function BtnSv2Suvis($usuarioid, $usuariostatus, $usuarioniveldeacesso, $pag_system, $get_sv2, $get_year, $get_pag, $get_id, $get_lixeira){
        if ($usuarioid === 1):
            return '';
        elseif ($usuariostatus === 0):
            return '';
        elseif ($usuarioniveldeacesso === 4):
            return '';
        elseif (!empty($get_id) && $get_sv2 !== 'suvis'):
            return '<a class="btn btn-outline-warning btn-sm fw-bold mb-2 me-2" href="'.$pag_system.'?pagina='.$get_pag.'&id='.$get_id.'&sv2=suvis&ano='.$get_year.'&lixeira='.$get_lixeira.'" role="button" accesskey="S"
                      data-toggle="tooltip" title="SV2 SUVIS"><i class="fal fa-plus-circle me-3"></i><u>S</u>UVIS<i class="ms-3"></i></a>';
        elseif($get_sv2 !== 'suvis'):
            return '<a class="btn btn-outline-warning btn-sm fw-bold mb-2 me-2" href="'.$pag_system.'?pagina='.$get_pag.'&sv2=suvis&ano='.$get_year.'" role="button" accesskey="S"
                      data-toggle="tooltip" title="SV2 SUVIS"><i class="fal fa-plus-circle me-3"></i><u>S</u>UVIS<i class="ms-3"></i></a>';
        else:
            return '';
        endif;
    }

    static function BtnSv2Covid($usuarioid, $usuariostatus, $usuarioniveldeacesso, $pag_system, $get_sv2, $get_year, $get_pag, $get_id, $get_lixeira){
        if ($usuarioid === 1):
            return '';
        elseif ($usuariostatus === 0):
            return '';
        elseif ($usuarioniveldeacesso === 4):
            return '';
        elseif (!empty($get_id) && $get_sv2 !== 'covid'):
            return '<a class="btn btn-outline-dark btn-sm fw-bold mb-2 me-2" href="'.$pag_system.'?pagina='.$get_pag.'&id='.$get_id.'&sv2=covid&ano='.$get_year.'&lixeira='.$get_lixeira.'" role="button" accesskey="S"
                      data-toggle="tooltip" title="SV2 SUVIS"><i class="fal fa-plus-circle me-3"></i><u>C</u>OVID<i class="ms-3"></i></a>';
        elseif($get_sv2 !== 'covid'):
            return '<a class="btn btn-outline-dark btn-sm fw-bold mb-2 me-2" href="'.$pag_system.'?pagina='.$get_pag.'&sv2=covid&ano='.$get_year.'" role="button" accesskey="S"
                       data-toggle="tooltip" title="SV2 SUVIS"><i class="fal fa-plus-circle me-3"></i><u>C</u>OVID<i class="ms-3"></i></a>';
        else:
            return '';
        endif;
    }

    static function BtnSv2Outros($usuarioid, $usuariostatus, $usuarioniveldeacesso, $pag_system, $get_sv2, $get_year, $get_pag, $get_id, $get_lixeira){
        if ($usuarioid === 1):
            return '';
        elseif ($usuariostatus === 0):
            return '';
        elseif ($usuarioniveldeacesso === 4):
            return '';
        elseif (!empty($get_id) && $get_sv2 !== 'outros'):
            return '<a class="btn btn-outline-danger btn-sm fw-bold mb-2 me-2" href="'.$pag_system.'?pagina='.$get_pag.'&id='.$get_id.'&sv2=outros&ano='.$get_year.'&lixeira='.$get_lixeira.'" role="button" accesskey="O"
                        data-toggle="tooltip" title="SV2 OUTROS"><i class="fal fa-plus-circle me-2"></i><u>O</u>UTROS<i class="ms-1"></i></a>';
        elseif($get_sv2 !== 'outros'):
            return '<a class="btn btn-outline-danger btn-sm fw-bold mb-2 me-2" href="'.$pag_system.'?pagina='.$get_pag.'&sv2=outros&ano='.$get_year.'" role="button" accesskey="O"
                        data-toggle="tooltip" title="SV2 OUTROS"><i class="fal fa-plus-circle me-2"></i><u>O</u>UTROS<i class="ms-1"></i></a>';
        else:
            return '';
        endif;
    }

    static function BtnSv2Siva($usuarioid, $usuariostatus, $usuarioniveldeacesso, $pag_system, $get_sv2, $get_year, $get_pag, $get_id, $get_lixeira){
        if ($usuarioid === 1):
            return '';
        elseif ($usuariostatus === 0):
            return '';
        elseif ($usuarioniveldeacesso === 4):
            return '';
        elseif (!empty($get_id) && $get_sv2 !== 'siva'):
            return '<a class="btn btn-outline-secondary btn-sm fw-bold mb-2 me-2"  href="'.$pag_system.'?pagina='.$get_pag.'&id='.$get_id.'&sv2=siva&ano='.$get_year.'&lixeira='.$get_lixeira.'" role="button" accesskey="I"
                        data-toggle="tooltip" title="SV2 SIVA"><i class="fal fa-plus-circle me-3"></i>S<u>I</u>VA<i class="ms-3"></i></a>';
        elseif($get_sv2 !== 'siva'):
            return '<a class="btn btn-outline-secondary btn-sm fw-bold mb-2 me-2" href="'.$pag_system.'?pagina='.$get_pag.'&sv2=siva&ano='.$get_year.'" role="button" accesskey="I"
                        data-toggle="tooltip" title="SV2 SIVA"><i class="fal fa-plus-circle me-3"></i>S<u>I</u>VA<i class="ms-3"></i></a>';
        else:
            return '';
        endif;
    }

    static function SinanProtSv2($get_sv2, $sv2sinan, $sv2protocolo) {
        if (str_starts_with($get_sv2, 'covid')):
            return '<div class="col-sm-2">
                        <label for="inputSinan" class="col-form-label-sm">PROT. COVID</label>
                            <input type="number" tabindex="2" class="form-control form-control-sm" data-toggle="tooltip" title="O protocolo deve ter 12 numeros" name="protocolo"
                           id="protocolo" size="12" value="'.$sv2protocolo.'" autofocus placeholder="000000000000">
            </div>';

        elseif(str_starts_with($get_sv2, 'siva')):
            return '';
        else:
            return '<div class="col-sm-2">
                        <label for="inputSinan" class="col-form-label-sm">SINAN</label>
                            <input tabindex="1" type="number" class="form-control form-control-sm" data-toggle="tooltip" title="O sinan deve ter 7 numeros" name="sinan" id="sinancad"
                                size="7" placeholder="0000000" value="'.$sv2sinan.'" autofocus></div>';
        endif;
    }

    static function SurtoOcorr($get_sv2, $sv2surto) {
        if(str_starts_with($get_sv2, 'surto')):
            return '<div class="col-sm-2">
                        <label for="inputOcorrencia" class="col-form-label-sm">L. OCOR.</label>
                            <input type="text" class="form-control ocorrencia" data-toggle="tooltip" 
                                title="Ex: Residência, Asilo, Hospital ..." name="ocorrencia" required
                            placeholder="RESIDENCIA , ASILO, HOSPITAL" value="'.$sv2surto.'" onchange="upperCaseF(this)"></div>';
        else:
            return '';
        endif;
    }



    static function BtnSv2SivaOutros($usuarioid, $usuariostatus, $usuarioniveldeacesso, $pag_system, $get_sv2, $get_year, $get_pag, $get_id, $get_lixeira){
        if ($usuarioid === 1):
            return '';
        elseif ($usuariostatus === 0):
            return '';
        elseif ($usuarioniveldeacesso === 4):
            return '';
        elseif (!empty($get_id) && $get_sv2 !== 'siva-outros'):
            return '<a class="btn btn-outline-secondary btn-sm fw-bold mb-2 me-2" href="'.$pag_system.'?pagina='.$get_pag.'&id='.$get_id.'&sv2=siva-outros&ano='.$get_year.'&lixeira='.$get_lixeira.'" role="button" accesskey="I"
                        data-toggle="tooltip" title="SV2 SIVA OUTROS"><i class="fal fa-plus-circle text-danger me-1"></i>  SI<u>V</u>A<i class="ms-1 text-danger">OUT</i></a>';
        elseif($get_sv2 !== 'siva-outros'):
            return '<a class="btn btn-outline-secondary btn-sm fw-bold mb-2 me-2" href="'.$pag_system.'?pagina='.$get_pag.'&sv2=siva-outros&ano='.$get_year.'" role="button" accesskey="I"
                        data-toggle="tooltip" title="SV2 SIVA OUTROS"><i class="fal fa-plus-circle text-danger me-1"></i>  SI<u>V</u>A<i class="ms-1 text-danger">OUT</i></a>';
        else:
            return '';
        endif;
    }

    static function BtnSv2Surto($usuarioid, $usuariostatus, $usuarioniveldeacesso, $pag_system, $get_sv2, $get_year, $get_pag, $get_id, $get_lixeira){
        if ($usuarioid === 1):
            return '';
        elseif ($usuariostatus === 0):
            return '';
        elseif ($usuarioniveldeacesso === 4):
            return '';
        elseif (!empty($get_id) &&$get_sv2 !== 'surto'):
            return '<a class="btn btn-outline-primary btn-sm fw-bold mb-2 me-2" href="'.$pag_system.'?pagina='.$get_pag.'&id='.$get_id.'&sv2=surto&ano='.$get_year.'&lixeira='.$get_lixeira.'" role="button" accesskey="U" value="surto" id="surto"
                        data-toggle="tooltip" title="SV2 SURTO"><i class="fal fa-plus-circle me-2"></i>S<u>U</u>RTO<i class="ms-2"></i></a>';
        elseif($get_sv2 !== 'surto'):
            return '<a class="btn btn-outline-primary btn-sm fw-bold mb-2 me-2" href="'.$pag_system.'?pagina='.$get_pag.'&sv2=surto&ano='.$get_year.'" role="button" accesskey="U" value="surto" id="surto"
                        data-toggle="tooltip" title="SV2 SURTO"><i class="fal fa-plus-circle me-2"></i>S<u>U</u>RTO<i class="ms-2"></i></a>';
        else:
            return '';
        endif;
    }

    static function BtnSv2CovidOutros($usuarioid, $usuariostatus, $usuarioniveldeacesso, $pag_system, $get_sv2, $get_year, $get_pag, $get_id, $get_lixeira){
        if ($usuarioid === 1):
            return '';
        elseif ($usuariostatus === 0):
            return '';
        elseif ($usuarioniveldeacesso === 4):
            return '';
        elseif (!empty($get_id) && $get_sv2 !== 'covid-outros'):
            return '<a class="btn btn-outline-dark btn-sm fw-bold mb-2 me-2" href="'.$pag_system.'?pagina='.$get_pag.'&id='.$get_id.'&sv2=covid-outros&ano='.$get_year.'&lixeira='.$get_lixeira.'" role="button" accesskey="I"
                   data-toggle="tooltip" title="SV2 COVID OUTROS"><i class="fal fa-plus-circle text-danger me-1"></i> COV<u>I</u>D<i class="ms-1 text-danger">OUT</i></a>';
        elseif($get_sv2 !== 'covid-outros'):
            return '<a class="btn btn-outline-dark btn-sm fw-bold mb-2 me-2" href="'.$pag_system.'?pagina='.$get_pag.'&sv2=covid-outros&ano='.$get_year.'" role="button" accesskey="I"
                   data-toggle="tooltip" title="SV2 COVID OUTROS"><i class="fal fa-plus-circle text-danger me-1"></i> COV<u>I</u>D<i class="ms-1 text-danger">OUT</i></a>';
        else:
            return '';
        endif;
    }



}

/* Chamada de classe de formulário e classe de botões */
$sv2s = new Sv2();