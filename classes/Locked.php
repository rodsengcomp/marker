<?php



class Locked {

    static function Deslogado($usuarioid, $get_pag){
        if($usuarioid == 0 && (str_starts_with($get_pag, 'cadastrar'))):
            return header("Location: index");
        elseif($usuarioid == 0 && (str_starts_with($get_pag, 'editar'))):
            return header("Location: index");
        else:
            return '';
        endif;
    }


    static function Cadastrar($usuarioid, $get_pag){
        if($usuarioid != 0 && (str_starts_with($get_pag, 'cadastrar'))):
            return header("Location: menu");
        elseif($usuarioid == 0 && (str_starts_with($get_pag, 'editar'))):
            return header("Location: menu");
        else:
            return '';
        endif;
    }

/*if ($usuarioniveldeacesso > 3) : echo '<div class="alert alert-danger text-center" id="usuariook" role="alert"><strong> SEU NÍVEL DE USUÁRIO NÃO PERMITE CADASTRAR !!! </strong></div>';
else : '';
endif;*/

    static function Disabled($usuarioid, $config_user) {
        if ($usuarioid == 1):
            return '<fieldset disabled>';
        elseif ($config_user->status == 0):
            return '<fieldset disabled>';
        elseif ($config_user->nivel_acesso_id == 4):
            return '<fieldset disabled>';
        else:
            return '<fieldset>';
        endif;
    }

    static function Logar($usuarioid){
        if ($usuarioid == 0) : echo '<div class="alert alert-danger text-center" id="usuariook" role="alert">
            <strong><i class="fal fa-user-lock me-2"></i> APENAS VISUALIZAÇÃO DISPONÍVEL - FAÇA <i class="fa fa-hand-o-up">
                </i> LOGIN !!! </strong></div>';
        endif;
    }

    static function Status($usuarioid, $config_user){
    if ($usuarioid != 0 && $config_user->status == 0) :
        return '<div class="alert alert-danger text-center" id="usuariook" role="alert"><strong> PARA ACESSAR É NECESSARIO ATIVAR SEU USUÁRIO !!! </strong></div>';
    endif;
    }

    /*Função para verificar se o usuário esta cadastrado no sistema e após Ok, */
    static function HashPag($hashsession, $pag_admin, $get_hash) {
        if (isset($get_hash)) :
            if(empty($hashsession)):
                header("Location: painel/$pag_admin");
            else:
                header("Location: painel/$pag_admin?pagina='.$get_pag");
            endif;
        else:
            header("Location: painel/$pag_admin");
        endif;

    }
}