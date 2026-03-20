<?php
declare(strict_types=1);

$pageTitle = "Contato";
$activePage = "contato";

require __DIR__ . "/includes/header.php";
?>
      <section class="hero-panel">
        <h1>Formulário para contato</h1>
      </section>

      <section class="form-panel">
        <form class="contact-form" method="POST" action="destino-contato.php" accept-charset="UTF-8">
          <div class="form-grid">
            <div class="field-group">
              <label for="nome">Nome:</label>
              <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>
            </div>

            <div class="field-group">
              <label for="email">E-mail</label>
              <input type="email" id="email" name="email" placeholder="Digite seu email" required>
            </div>
          </div>

          <div class="field-group">
            <label for="mensagem">Mensagem</label>
            <textarea id="mensagem" name="mensagem" rows="5" required></textarea>
          </div>

          <div class="button-row centered-row">
            <button class="btn btn-primary" type="submit">Enviar</button>
            <button class="btn btn-warning" type="reset">Limpar</button>
          </div>
        </form>
      </section>
<?php require __DIR__ . "/includes/footer.php"; ?>
