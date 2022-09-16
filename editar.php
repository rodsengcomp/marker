<?php
?>

<!-- Este projeto é desenvolvido na Suvis Jaçanã-Tremembé com iniciativa dos colaboradores da Unidade -->
<!-- Código desenvolvido por Rodolfo Romaioli Ribeiro de Jesus - rodolfo.romaioli@gmail.com -->
<!-- Sisdam Web - 2.0 - 2017 - Todos os direitos reservados -->

<?php
error_reporting(1);

include_once 'Conexao.php';
include_once 'classes/Tables.php';
include_once 'classes/Buttons.php';

// Select all the rows in the markers table
$conexao = conexao::getInstance();

// $ano_cad = "SELECT anocad FROM ano ";


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>

    <?php
    if (isset($_SESSION['msgok'])) {
        echo $_SESSION['msgok'];
        unset($_SESSION['msgok']);
    }

    // Recebe o id do cliente do cliente via GET
    $id = (isset($_GET['id'])) ? $_GET['id'] : '';

    // Captura os dados do documento solicitado
    $sql = "SELECT id_esp, lat, lng FROM esporo_an WHERE id_esp = :id_esp";
            $stm = $conexao->prepare($sql);
            $stm->bindValue(':id_esp', $id);
            $stm->execute();
            $map = $stm->fetch(PDO::FETCH_OBJ);

    ?>

<div class="container">
    <main>

        <div class="py-5 text-center">
            <h2>LAT/LNG</h2>
        </div>
        <div class="row g-5">

            <div class="col-md-6 col-lg-6">
                <h4 class="mb-3">Cadastro</h4>

                <form class="needs-validation" novalidate method="POST" action="action">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="firstName" name="lat" maxlength="10" placeholder="" value="<?=$map->lat?>" required>
                            <div class="invalid-feedback">
                                Digite a Latitude.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="lastName" name="lng" placeholder="" value="<?=$map->lng?>" required>
                            <div class="invalid-feedback">
                                Digite a Longitude.
                            </div>
                        </div>

                    </div>

                    <hr class="my-4">
                    <input type="hidden" name="acao" value="editar">
                    <input type="text" name="id" value="<?=$map->id_esp?>">
                    <button class="btn btn-outline-success" type="submit">Gravar</button>
                </form>
            </div>
        </div>
    </main>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017–2022 Company Name</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Privacy</a></li>
            <li class="list-inline-item"><a href="#">Terms</a></li>
            <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
    </footer>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="js/form-validation.js"></script>

</body>
</html>
