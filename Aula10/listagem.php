<?php
require 'header.php';
?>

<div class="inicio">
    <div class="bg-light p-4 mb-4 rounded">
        <h1 class="text-center">Listagem dos dados</h1>
    </div>

    <?php
    require "conexao.php";

    $sql = "SELECT id, nome, email, mensagem, 
                   DATE_FORMAT(datahora, '%d/%m/%Y %H:%i:%s') AS datahora 
            FROM contato 
            ORDER BY id";

    $stmt = $conn->query($sql);
    $registros = $stmt->fetchAll();
    $count = count($registros);

    if ($count == 0) {
    ?>
        <div class="alert alert-warning" role="alert">
            <h4>Atenção</h4>
            <p>Não há nenhum registro na tabela <b>contato</b>.</p>
        </div>
    <?php
    } else {
    ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col" style="width: 10%;">ID</th>
                        <th scope="col" style="width: 15%;">Nome</th>
                        <th scope="col" style="width: 15%;">E-mail</th>
                        <th scope="col" style="width: 30%;">Mensagem</th>
                        <th class="text-center" scope="col" style="width: 15%;">Data/Hora</th>
                        <th scope="col" style="width: 15%;" colspan="2">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($registros as $row) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['nome']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['mensagem']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['datahora']) ?></td>
                            <td>
                                <a class="btn btn-sm btn-warning" href="contato-alterar.php?id=<?= $row['id']; ?>">
                                    Editar
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-danger" 
                                   href="excluir-contato.php?id=<?= $row['id']; ?>" 
                                   onclick="if(!confirm('Tem certeza que deseja excluir?')) return false;">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php
    }
    ?>
</div>

<?php
require 'footer.php';
?>
