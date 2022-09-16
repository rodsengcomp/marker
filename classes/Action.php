<?php

/**
 *
 */

include_once 'Tables.php';
class Action extends Tables {

    /**
     * @param $icon
     * @param $text1
     * @param $text2
     * @param $text3
     * @param $text4
     * @param $text5
     * @return string
     */
    static function MsgError($icon, $text) {
        return $_SESSION['msgerro'] =
            '<div class="alert alert-danger text-center text-uppercase" role="alert"><strong>
                <i class="fal fa-'.$icon.' px-2"></i>'.$text.' !!!</strong>
            </div>';
    }

    /**
     * @param $alert
     * @param $icon
     * @param $text1
     * @param $text2
     * @param $text3
     * @param $text4
     * @param $text5
     * @return string
     */
    static function MsgSuccess($alert, $icon, $text) {
        return $_SESSION['msgsuccess'] =
            '<div class="alert alert-'.$alert.' text-center text-uppercase" role="alert"><strong>
                <i class="fal fa-'.$icon.' px-2"></i>'.
            $text.' !!!</strong>
            </div>';
    }

    // Função para enviar registros a lixeira

    /**
     * @param $action
     * @param $idaction
     * @param $usuarioniveldeacesso
     * @param $nameaction
     * @param $conexaotable
     * @param $nametabela
     * @param $usuariologin
     * @param $form
     * @param $nomeform
     * @return string|void
     */
    public function Lixeira($action, $idaction, $usuarioniveldeacesso, $nameaction, $conexaotable, $nametabela, $usuariologin, $form, $nomeform, $get_year, $ano_atual) {

        // Verifica se foi solicitada a exclusão dos dados
        if ($action === 'lixeira'):

            // Valida se existe um id e se ele é numérico
            if (!empty($idaction) && is_numeric($idaction)):
                // Se o usuário não tem permissão para excluir o registro devolve a mensagem
                if ($usuarioniveldeacesso <> 1):
                    return $this->MsgError('exclamation-triangle', ' SEU NÍVEL DE USUÁRIO NÃO PERMITE ENVIAR O REGISTRO '.$nomeform.' : '.$nameaction.' A LIXEIRA !!!').
                        header("Location: $pag_system?pagina=listar-$form&ano=$get_year&lixeira=1");
                else:
                    // Exclui o registro do banco de dados
                    $sql = "UPDATE $nametabela SET lixeira=1,usuarioalt=:usuarioalt,alterado=NOW() WHERE id = :id";
                    $stm = $conexaotable->prepare($sql);
                    $stm->bindValue(':id', $idaction);
                    $stm->bindValue(':usuarioalt', $usuariologin);
                    $retorno = $stm->execute();

                    if ($retorno) :
                            if($get_year == $ano_atual):
                                return  $this->MsgSuccess('secondary', 'thumbs-up', ' O REGISTRO DE '.$nomeform.' : '.$nameaction.' - FOI ENVIADO A LIXEIRA COM SUCESSO !!!').
                                header("Location: $pag_system?pagina=listar-$form");
                            else:
                                return  $this->MsgSuccess('secondary', 'thumbs-up', ' O REGISTRO DE '.$nomeform.' : '.$nameaction.' - FOI ENVIADO A LIXEIRA COM SUCESSO !!!').
                                header("Location: $pag_system?pagina=listar-$form&ano=$get_year");
                            endif;

                    else :
                        return $this->MsgError('exclamation-triangle', ' ERRO AO REATIVAR O REGISTRO DE '.$nomeform.' : '.$nameaction.' - NÃO FOI ENCONTRADO !!!').
                            header("Location: $pag_system?pagina=listar-$form&ano=$get_year");
                    endif;
                endif;
            else:
                return $this->MsgError('exclamation-triangle', ' O REGISTRO DE '.$nomeform.' : '.$nameaction.' - NÃO FOI ENCONTRADO !!!').
                    header("Location: $pag_system?pagina=listar-$form&ano=$get_year");
            endif;
        endif;

    }

    /**
     * @param $action
     * @param $idaction
     * @param $usuarioniveldeacesso
     * @param $nameaction
     * @param $conexaotable
     * @param $nametabela
     * @param $usuariologin
     * @param $form
     * @param $nomeform
     * @return string|void
     */
    public function Reativar($action, $idaction, $usuarioniveldeacesso, $nameaction, $conexaotable, $nametabela, $usuariologin, $form, $nomeform, $get_year, $ano_atual) {

        // Verifica se foi solicitada a exclusão dos dados
        if ($action === 'reativacao'):

            // Valida se existe um id e se ele é numérico
            if (!empty($idaction) && is_numeric($idaction)):
                if ($usuarioniveldeacesso <> 1):
                    return $this->MsgError('exclamation-triangle', ' SEU NÍVEL DE USUÁRIO NÃO PERMITE REATIVAR O REGISTRO '.$nomeform.' : '.$nameaction.' !!!').
                            header("Location: $pag_system?pagina=listar-$form&lixeira=1");
                else:
                    // Exclui o registro do banco de dados
                    $sql = "UPDATE $nametabela SET lixeira=0,usuarioalt=:usuarioalt,alterado=NOW() WHERE id = :id";
                    $stm = $conexaotable->prepare($sql);
                    $stm->bindValue(':id', $idaction);
                    $stm->bindValue(':usuarioalt', $usuariologin);
                    $retorno = $stm->execute();

                    if ($retorno) :
                        if($get_year == $ano_atual):
                        return $this->MsgSuccess('warning', 'thumbs-up', ' O REGISTRO DE '.$nomeform.' : '.$nameaction.' - FOI REATIVADO COM SUCESSO ').
                            header("Location: $pag_system?pagina=listar-$form&lixeira=1");
                        else:
                            return $this->MsgSuccess('warning', 'thumbs-up', ' O REGISTRO DE '.$nomeform.' : '.$nameaction.' - FOI REATIVADO COM SUCESSO ').
                                header("Location: $pag_system?pagina=listar-$form&ano=$get_year&lixeira=1");
                        endif;
                    else :
                        return $this->MsgError('exclamation-triangle', ' ERRO AO REATIVAR O REGISTRO DE '.$nomeform.' : '.$nameaction.' - NÃO FOI ENCONTRADO !!!').
                            header("Location: $pag_system?pagina=listar-$form&lixeira=1");
                    endif;
                endif;
            else:
                return $this->MsgError('exclamation-triangle', ' O REGISTRO DE '.$nomeform.' : '.$nameaction.' - NÃO FOI ENCONTRADO !!!').
                    header("Location: $pag_system?pagina=listar-$form&lixeira=1");
            endif;
        endif;

    }


}