<?php
require 'header.php';
?>

<div class="inicio">
    <div class="bg-light p-4 mb-4 rounded">
        <h1 class="text-center">Página para excluir contato</h1>
    </div>

    <div class="row">
        <?php
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

        require "conexao.php";

        $sql = "DELETE FROM contato WHERE id = ?";

        try {
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([$id]);
        } catch (Exception $e) {
            $result = false;
            $error = $e->getMessage();
        }

        if ($result == true) {
        ?>
            <div class="alert alert-success" role="alert">
                <h4>Registro apagado com sucesso!</h4>
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-danger" role="alert">
                <h4>Falha ao efetuar exclusão.</h4>
                <p><?= htmlspecialchars($error) ?></p>
            </div>
        <?php
        }
        ?>
    </div>

    <a href="listagem.php" class="btn btn-info ms-5" role="button">Voltar</a>
</div>

<?php
require 'footer.php';
?>
