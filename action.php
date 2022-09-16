<!-- Este projeto é desenvolvido na Suvis Jaçanã-Tremembé com iniciativa dos colaboradores da Unidade -->
<!-- Código desenvolvido por Rodolfo Romaioli Ribeiro de Jesus - rodolfo.romaioli@gmail.com -->
<!-- Sisdam Web - 2.0 - 2017 - Todos os direitos reservados -->

<?php

error_reporting(1);
include_once 'Conexao.php';

$conexao = conexao::getInstance();

#Recolhendo os dados do formulário
$id =   $_POST['id'] ?? '';
$lat =  $_POST['lat'] ?? '';
$lng =  $_POST['lng'] ?? '';
$acao = $_POST['acao'] ?? '';


// Verifica se foi solicitada a edição de dados
if ($acao === 'editar'):

    // Valida se existe um id e se ele é numérico
    if (!empty($id) && is_numeric($id)):
        # Verificando vários campos.
        $sql = "SELECT * FROM esporo_an WHERE lat='$lat' AND lng='$lng' AND id_esp<>'$id'";
        $stm = $conexao->prepare($sql);
        $stm->execute();

            if ($stm->rowCount() > 0) :
                header("Location: editar?id=$id");
            else :
                $sql = "UPDATE esporo_an SET lat=:lat, lng=:lng WHERE id_esp=:id";

                $stm = $conexao->prepare($sql);
                $stm->bindValue(':lat', $lat);
                $stm->bindValue(':lng', $lng);
                $stm->bindValue(':id', $id);
                $retorno = $stm->execute();

                if($retorno) :
                    $_SESSION['msgedit'] = '<div class="alert alert-primary" role="alert">A simple primary alert—check it out!</div>';
                    header("Location: index");
                else :
                    header("Location: editar?id=$id");
                endif;
            endif;
    else:
      header("Location: index");
    endif;
endif;

?>
