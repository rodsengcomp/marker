<?php


include_once '../../Conexao.php';

function parseToXML($htmlStr)
{
    $xmlStr = str_replace('<', '&lt;', $htmlStr);
    $xmlStr = str_replace('>', '&gt;', $xmlStr);
    $xmlStr = str_replace('"', '&quot;', $xmlStr);
    $xmlStr = str_replace("'", '&#39;', $xmlStr);
    $xmlStr = str_replace("&", '&amp;', $xmlStr);
    return $xmlStr;
}

// Select all the rows in the markers table
$conexao = conexao::getInstance();

$sql = "SELECT esporo_an.id_esp, esporo_an.tutor, esporo_an.nome_animal, esporo_an.data_entrada, esporo_an.rua_esp_a, 
            esporo_an.id_rua, esporo_an.numero, esporo_an.complemento, esporo_an.lat, esporo_an.lng, 
            especie_animal.especie
            FROM esporo_an 
            LEFT JOIN especie_animal ON esporo_an.especie = especie_animal.id_especie";
$resultado_markers = $conexao->prepare($sql);
$resultado_markers->execute();

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// Iterate através das linhas, imprimindo nós XML para cada
while ($row_markers = $resultado_markers->fetch(PDO::FETCH_ASSOC)) :
    // Add to XML document node
    echo '<marker ';
    echo 'id="' . $row_markers['id_esp'] . '" ';
    echo 'name="'. $row_markers['tutor'].'" ';
    echo 'name_animal="'. $row_markers['nome_animal'].'" ';
    echo 'dataentrada="'. $row_markers['data_entrada'].'" ';
    echo 'address="'. $row_markers['rua_esp_a'].'" ';
    echo 'idrua="'. $row_markers['id_rua'] .'" ';
    echo 'num="'. $row_markers['numero'].'" ';
    echo 'comp="'. $row_markers['complemento'].'" ';
    echo 'lat="' . $row_markers['lat'] . '" ';
    echo 'lng="' . $row_markers['lng'] . '" ';
    echo 'type="' . $row_markers['especie'] . '" ';
    echo '/>';
endwhile;

// End XML file
echo '</markers>';
