<?php

$conexao = conexao::getInstance();

if(isset($config_user->nm_social) && $config_user->nm_social == 1 && $config_user->nomesocial != ''):
    $usuarionome = $config_user->nomesocial; endif;

if(!empty($config_user->textcolor) && $config_user->textcolor == 'dark'): $text_colors = 'light';
elseif(!empty($config_user->textcolor) && $config_user->textcolor == 'light'): $text_colors = 'dark';
else: $text_colors = 'light'; endif;


class Users {

    static function fotoUsuario($usuariologin, $config_user, $file) {
        if($usuariologin != 'D000000'):
            if (file_exists($file.'imagens/' . $usuariologin . '/fotologin/' . $config_user->foto)):
                return $file.'imagens/' . $usuariologin . '/fotologin/' . $config_user->foto;
            else:
                return 'imagens/foto_exists.png';
            endif;
        endif;
    }

    static function cargoUsuario($usuarioid, $list_user, $cargofetch) {
        if(empty($usuarioid)):
            return 'SERVIDOR PÚBLICO';
        else:
            foreach ($cargofetch as $cargofetchs):
                if ($list_user->cargo == $cargofetchs->id):
                    return $cargofetchs->cargo;
                endif;
            endforeach;
        endif;
    }

    static function nivelUsuario($usuarioid, $list_user, $nivelfetch) {
        if(empty($usuarioid)):
            return 'VISITANTE';
        else:
            if($list_user->nivel_acesso_id == 0):
                return 'ERROR';
            else:
                foreach ($nivelfetch as $nivelfetchs):
                    if ($list_user->nivel_acesso_id == $nivelfetchs->id):
                        return $nivelfetchs->nivel_acesso_id;
                    endif;
                endforeach;
            endif;
        endif;
    }

    static function nomeSocialUsuario($pag_system, $nomesocial, $nmsocial)
    {
        if ($nomesocial == NULL) :
            return '<h6 class="card-text text-danger mb-2"><a href="' . $pag_system . '?pagina=editar-usuario"><i class="fal fa-user fa-muted me-2"></i>
                        NOME SOCIAL : VOCÊ PODE USAR !!!</a></h6>';
        elseif ($nomesocial != '' && $nmsocial == 0):
            return '<h6 class="card-text text-danger mb-2"><i class="fal fa-user-check fa-muted me-2"></i>
                        NOME SOCIAL : ' . $nomesocial . '</p>';
        else:
            return '<h6 class="card-text text-success mb-2"><i class="fal fa-user-check fa-muted me-2"></i>
                    NOME SOCIAL : ' . $nomesocial . '</p>';
        endif;
    }

    static function nomeUser($usuarionome, $nomesocial, $nmsocial)
    {
        if ($nomesocial != '' && $nmsocial == 1):
            return '';
        else:
            return '<h6 class="card-text mb-2"><i class="fal fa-user fa-muted me-2"></i>' . $usuarionome . '</h6>';
        endif;
    }

    static function configUserNav($usuarioid, $config_user){

        if(empty($usuarioid)):
            return 'navbar-dark bg-dark navbar-expand-sm fixed-top"';
        elseif ($config_user->bgcolor != '' && $usuarioid != 0):
            return 'navbar-'.$config_user->textcolor.' bg-'.$config_user->bgcolor.' navbar-expand-sm fixed-top"';
        elseif ($config_user->cornavcustom != '' && $usuarioid != 0):
            return 'navbar-'.$config_user->textcolor.' navbar-expand-sm fixed-top" style="background-color: '.$config_user->cornavcustom.'"';
        else :
            return 'navbar-dark bg-dark navbar-expand-sm fixed-top"';
        endif;
    }

    static function configUserSidebar($usuarioid, $config_user){

        if(empty($usuarioid)):
            return '"navbar-nav bg-dark sidebar sidebar-light accordion"';
        elseif ($config_user->bgcolor != '' && $usuarioid != 0):
            return '"navbar-nav bg-'.$config_user->bgcolor.' sidebar sidebar-'.$config_user->textcolor.' accordion"';
        elseif ($config_user->cornavcustom != '' && $usuarioid != 0):
            return '"navbar-nav sidebar sidebar-'.$config_user->textcolor.' accordion" style="background-color: '.$config_user->cornavcustom.'"';
        else :
            return '"navbar-nav bg-dark sidebar sidebar-light accordion"';
        endif;
    }

    static function configUserFooter($usuarioid, $config_user, $text_colors){
        if(empty($usuarioid)):
            return 'bg-dark text-light"';
        elseif ($config_user->bgcolor != '' && $usuarioid != 0):
            return 'bg-'.$config_user->bgcolor.' text-'.$text_colors.'"';
        elseif ($config_user->cornavcustom != '' && $usuarioid != 0):
            return 'text-'.$text_colors.'" style="background-color: '.$config_user->cornavcustom.'"';
        else :
            return 'bg-dark text-light"';
        endif;
    }

    static function configUserCard($usuarioid, $config_user){
        if(empty($usuarioid)):
            return '<div class="card shadow-lg"> <!-- Início do Card -->
                    <div class="card-header text-center fw-bold fs-6">';
        elseif ($config_user->bgcolor != '' && $usuarioid != 0):
            return '<div class="card shadow-lg border-'.$config_user->bgcolor.'">
                    <div class="card-header text-center fw-bold fs-6 border-'.$config_user->bgcolor.'">';
        elseif ($config_user->cornavcustom != '' && $usuarioid != 0):
            return '<div class="card shadow-lg" style="border-color: '.$config_user->cornavcustom.'">
                    <div class="card-header text-center fw-bold fs-6" style="border-color: '.$config_user->cornavcustom.'">';
        else :
            return '<div class="card shadow-lg"> <!-- Início do Card -->
                    <div class="card-header text-center fw-bold fs-6">';
        endif;
    }

    static function dataNascimento($pag_system, $datanacimento) {
        if($datanacimento == NULL) :
            return '<h6><a class="card-text text-danger mb-2" href="'.$pag_system.'?pagina=editar-usuario">
                        <i class="fal fa-calendar-day fa-muted me-2"></i> NASCIMENTO : COMPLETE SUAS INFORMAÇÕES</a></h6>';
        elseif($datanacimento == 0000-00-00) :
            return '<h6><a class="card-text text-danger mb-2"href="'.$pag_system.'?pagina=editar-usuario">
                    <i class="fal fa-calendar-day fa-muted me-2"></i> NASCIMENTO : COMPLETE SUAS INFORMAÇÕES</a></h6>';
        elseif($datanacimento == '') :
            return '<h6><a class="card-text text-danger mb-2" href="'.$pag_system.'?pagina=editar-usuario">
                    <i class="fal fa-calendar-day fa-muted me-2"></i> NASCIMENTO : COMPLETE SUAS INFORMAÇÕES</a></h6>';
        else:
            return '';
        endif;
    }

    static function completaInformacao($pag_system, $informacao, $texto, $icon) {
        if($informacao == NULL) :
            return '<h6><a class="card-text text-danger mb-2" href="'.$pag_system.'?pagina=editar-usuario">
                        <i class="fal fa-'.$icon.' fa-muted me-2"></i> '.$texto.' : COMPLETE SUAS INFORMAÇÕES</a></h6>';
        elseif($informacao == '') :
            return '<h6"><a class="card-text text-danger mb-2" href="'.$pag_system.'?pagina=editar-usuario">
                    <i class="fal fa-'.$icon.' fa-muted me-2"></i> '.$texto.' : COMPLETE SUAS INFORMAÇÕES</a></h6>';
        else:
            return '';
        endif;
    }
}