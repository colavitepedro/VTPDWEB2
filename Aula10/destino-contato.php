<?php
date_default_timezone_set('America/Sao_Paulo');

require 'header.php';
?>

<div class="inicio">
    <div class="bg-light p-4 mb-4 rounded">
        <h1 class="text-center">Cadastro de contato</h1>
    </div>

    <div class="row">
        <?php
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $msg = filter_input(INPUT_POST, "msg", FILTER_SANITIZE_SPECIAL_CHARS);

        require "conexao.php";

        $sql = "INSERT INTO contato (nome, email, mensagem) VALUES (?, ?, ?)";

        try {
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([$nome, $email, $msg]);
        } catch (Exception $e) {
            $result = false;
            $error = $e->getMessage();
        }

        if ($result == true) {
        ?>
            <div class="alert alert-success" role="alert">
                <h4>Dados gravados com sucesso!</h4>
                <p><strong>Nome:</strong> <?= htmlspecialchars($nome) ?></p>
                <p><strong>E-mail:</strong> <?= htmlspecialchars($email) ?></p>
                <p><strong>Mensagem:</strong> <?= htmlspecialchars($msg) ?></p>
                <p><strong>Data:</strong> <?= date("d/m/Y - H:i:s") ?></p>
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-danger" role="alert">
                <h4>Falha ao efetuar gravação.</h4>
                <p><?= htmlspecialchars($error) ?></p>
            </div>
        <?php
        }
        ?>
    </div>

    <a href="contato.php" class="btn btn-info ms-5" role="button">Voltar</a>
    <a href="listagem.php" class="btn btn-secondary" role="button">Listagem</a>
</div>

<?php
require 'footer.php';
?>
